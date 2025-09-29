<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenRouterService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AIController extends Controller
{
    protected $openRouterService;

    public function __construct(OpenRouterService $openRouterService)
    {
        $this->middleware('auth');
        $this->openRouterService = $openRouterService;
    }

    /**
     * Display AI dashboard
     */
    public function index()
    {
        $recentInteractions = collect(); // Empty collection when not saving to database
        
        // Only load interactions if database saving is enabled
        if (config('services.openrouter.save_interactions', false)) {
            $recentInteractions = \App\Models\AIInteraction::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('ai.index', compact('recentInteractions'));
    }

    /**
     * Chat with AI
     */
    public function chat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:5000',
            'model' => 'nullable|string',
            'context' => 'nullable|string|in:medical,general,report'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $message = $request->input('message');
        $model = $request->input('model');
        $context = $request->input('context', 'general');

        // Add context-specific prompts
        if ($context === 'medical') {
            $message = "Sebagai asisten medis AI, jawab pertanyaan berikut dengan akurat dan profesional dalam bahasa Indonesia:\n\n" . $message;
        }

        $response = $this->openRouterService->chat($message, $model);

        // Optionally save interaction to database (configurable)
        $saveToDatabase = config('services.openrouter.save_interactions', false);
        $interactionId = null;
        
        if ($saveToDatabase) {
            $interaction = \App\Models\AIInteraction::create([
                'user_id' => Auth::id(),
                'message' => $request->input('message'),
                'response' => $response['message'],
                'model' => $model ?? $this->openRouterService->defaultModel,
                'context' => $context,
                'tokens_used' => $response['usage']['total_tokens'] ?? 0,
                'success' => $response['success']
            ]);
            $interactionId = $interaction->id;
        }

        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'interaction_id' => $interactionId,
            'usage' => $response['usage'] ?? [],
            'error' => $response['error'] ?? null
        ]);
    }

    /**
     * Analyze medical text
     */
    public function analyzeMedical(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:10000',
            'analysis_type' => 'required|string|in:general,diagnosis,treatment,plan,evaluation,summary'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $text = $request->input('text');
        $analysisType = $request->input('analysis_type');

        $response = $this->openRouterService->analyzeMedicalText($text, $analysisType);

        // Optionally save interaction to database
        if (config('services.openrouter.save_interactions', false)) {
            \App\Models\AIInteraction::create([
                'user_id' => Auth::id(),
                'message' => "Medical Analysis ({$analysisType}): " . substr($text, 0, 100) . '...',
                'response' => $response['message'],
                'model' => 'medical-analysis',
                'context' => 'medical',
                'tokens_used' => $response['usage']['total_tokens'] ?? 0,
                'success' => $response['success']
            ]);
        }

        return response()->json($response);
    }

    /**
     * Generate medical report
     */
    public function generateReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_data' => 'required|array',
            'patient_data.nama' => 'required|string',
            'patient_data.umur' => 'nullable|string',
            'patient_data.keluhan' => 'nullable|string',
            'patient_data.pemeriksaan' => 'nullable|string',
            'report_type' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $patientData = $request->input('patient_data');
        $reportType = $request->input('report_type', 'general');

        $response = $this->openRouterService->generateMedicalReport($patientData, $reportType);

        // Optionally save interaction to database
        if (config('services.openrouter.save_interactions', false)) {
            \App\Models\AIInteraction::create([
                'user_id' => Auth::id(),
                'message' => "Medical Report Generation for: " . $patientData['nama'],
                'response' => $response['message'],
                'model' => 'report-generation',
                'context' => 'medical',
                'tokens_used' => $response['usage']['total_tokens'] ?? 0,
                'success' => $response['success']
            ]);
        }

        return response()->json($response);
    }

    /**
     * Get available AI models
     */
    public function getModels()
    {
        $response = $this->openRouterService->getModels();
        return response()->json($response);
    }

    /**
     * Get AI interaction history
     */
    public function getHistory(Request $request)
    {
        // Return empty result if database saving is disabled
        if (!config('services.openrouter.save_interactions', false)) {
            return response()->json([
                'data' => [],
                'current_page' => 1,
                'total' => 0,
                'per_page' => $request->input('per_page', 15)
            ]);
        }

        $perPage = $request->input('per_page', 15);
        $context = $request->input('context');

        $query = \App\Models\AIInteraction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($context) {
            $query->where('context', $context);
        }

        $interactions = $query->paginate($perPage);

        return response()->json($interactions);
    }

    /**
     * Delete AI interaction
     */
    public function deleteInteraction($id)
    {
        // Return error if database saving is disabled
        if (!config('services.openrouter.save_interactions', false)) {
            return response()->json([
                'success' => false,
                'message' => 'Database interactions are disabled'
            ], 400);
        }

        $interaction = \App\Models\AIInteraction::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$interaction) {
            return response()->json([
                'success' => false,
                'message' => 'Interaction not found'
            ], 404);
        }

        $interaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Interaction deleted successfully'
        ]);
    }

    /**
     * Test AI connection
     */
    public function testConnection()
    {
        $testMessage = "Hello, this is a test message. Please respond with 'AI connection successful' in Indonesian.";
        
        $response = $this->openRouterService->chat($testMessage);

        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'test_result' => $response['success'] ? 'Connection successful' : 'Connection failed',
            'error' => $response['error'] ?? null
        ]);
    }
}
