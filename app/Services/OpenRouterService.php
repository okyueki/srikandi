<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenRouterService
{
    private $apiKey;
    private $baseUrl;
    private $defaultModel;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.api_key');
        $this->baseUrl = config('services.openrouter.base_url', 'https://openrouter.ai/api/v1');
        $this->defaultModel = config('services.openrouter.default_model', 'google/gemma-3n-e2b-it:free');
    }

    /**
     * Send a chat completion request to OpenRouter
     *
     * @param string $message
     * @param string|null $model
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function chat($message, $model = null, $options = [])
    {
        if (!$this->apiKey) {
            throw new Exception('OpenRouter API key not configured');
        }

        $model = $model ?? $this->defaultModel;

        $payload = array_merge([
            'model' => $model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ],
            'max_tokens' => 1000,
            'temperature' => 0.7,
        ], $options);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name', 'Srikandi'),
            ])->post($this->baseUrl . '/chat/completions', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                // Log successful request
                Log::info('OpenRouter API request successful', [
                    'model' => $model,
                    'tokens_used' => $data['usage']['total_tokens'] ?? 0
                ]);

                return [
                    'success' => true,
                    'data' => $data,
                    'message' => $data['choices'][0]['message']['content'] ?? '',
                    'usage' => $data['usage'] ?? []
                ];
            } else {
                throw new Exception('OpenRouter API request failed: ' . $response->body());
            }
        } catch (Exception $e) {
            Log::error('OpenRouter API error', [
                'error' => $e->getMessage(),
                'model' => $model
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => '',
                'data' => null
            ];
        }
    }

    /**
     * Get available models from OpenRouter
     *
     * @return array
     */
    public function getModels()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/models');

            if ($response->successful()) {
                return [
                    'success' => true,
                    'models' => $response->json()['data'] ?? []
                ];
            } else {
                throw new Exception('Failed to fetch models: ' . $response->body());
            }
        } catch (Exception $e) {
            Log::error('OpenRouter models fetch error', ['error' => $e->getMessage()]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'models' => []
            ];
        }
    }

    /**
     * Medical text analysis using AI
     *
     * @param string $medicalText
     * @param string $analysisType
     * @return array
     */
    public function analyzeMedicalText($medicalText, $analysisType = 'general')
    {
        $prompts = [
            'general' => "Analisis teks medis berikut dan berikan ringkasan dalam bahasa Indonesia (maksimal 2500 karakter):\n\n{$medicalText}",
            'diagnosis' => "Berdasarkan gejala dan tanda-tanda berikut, berikan kemungkinan diagnosis dalam bahasa Indonesia. Format: 1) Diagnosis utama, 2) Diagnosis banding, 3) Dasar diagnosis. Maksimal 2500 karakter, gunakan poin-poin singkat dan tepat:\n\n{$medicalText}",
            'treatment' => "Berikan rekomendasi pengobatan untuk kondisi medis berikut dalam bahasa Indonesia. Format: 1) Terapi farmakologi, 2) Terapi non-farmakologi, 3) Monitoring. Maksimal 2500 karakter, gunakan poin-poin singkat dan tepat:\n\n{$medicalText}",
            'plan' => "Berdasarkan data pemeriksaan dan diagnosis berikut, buatkan rencana tindak lanjut (plan) yang komprehensif dalam bahasa Indonesia. Format: 1) Pemeriksaan lanjutan, 2) Konsultasi, 3) Edukasi pasien, 4) Follow-up. Maksimal 2500 karakter, gunakan poin-poin singkat dan tepat:\n\n{$medicalText}",
            'evaluation' => "Berdasarkan data pemeriksaan, diagnosis, dan rencana pengobatan berikut, buatkan evaluasi medis yang objektif dalam bahasa Indonesia. Format: 1) Respons terapi, 2) Kondisi saat ini, 3) Prognosis, 4) Rekomendasi lanjutan. Maksimal 2500 karakter, gunakan poin-poin singkat dan tepat:\n\n{$medicalText}",
            'summary' => "Buat ringkasan singkat dari catatan medis berikut dalam bahasa Indonesia (maksimal 2500 karakter):\n\n{$medicalText}"
        ];

        $prompt = $prompts[$analysisType] ?? $prompts['general'];

        return $this->chat($prompt, null, [
            'temperature' => 0.2, // Lower temperature for more precise medical accuracy
            'max_tokens' => 800    // Reduced tokens to enforce character limit (~2500 chars)
        ]);
    }

    /**
     * Generate medical report using AI
     *
     * @param array $patientData
     * @param string $reportType
     * @return array
     */
    public function generateMedicalReport($patientData, $reportType = 'general')
    {
        $patientInfo = "Nama: " . ($patientData['nama'] ?? 'N/A') . "\n";
        $patientInfo .= "Umur: " . ($patientData['umur'] ?? 'N/A') . "\n";
        $patientInfo .= "Keluhan: " . ($patientData['keluhan'] ?? 'N/A') . "\n";
        $patientInfo .= "Pemeriksaan: " . ($patientData['pemeriksaan'] ?? 'N/A') . "\n";

        $prompt = "Buatkan laporan medis dalam bahasa Indonesia berdasarkan data pasien berikut:\n\n{$patientInfo}\n\nFormat laporan harus profesional dan sesuai standar medis.";

        return $this->chat($prompt, null, [
            'temperature' => 0.2,
            'max_tokens' => 2000
        ]);
    }
}
