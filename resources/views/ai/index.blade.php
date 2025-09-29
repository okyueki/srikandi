@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'AI Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-robot mr-2"></i>
                        AI Assistant Dashboard
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-info" onclick="testConnection()">
                            <i class="fas fa-plug"></i> Test Connection
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Connection Status -->
                    <div id="connection-status" class="alert alert-info" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Testing connection...
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="aiTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="chat-tab" data-toggle="tab" href="#chat" role="tab">
                                <i class="fas fa-comments"></i> Chat AI
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="medical-tab" data-toggle="tab" href="#medical" role="tab">
                                <i class="fas fa-stethoscope"></i> Medical Analysis
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="report-tab" data-toggle="tab" href="#report" role="tab">
                                <i class="fas fa-file-medical"></i> Generate Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab">
                                <i class="fas fa-history"></i> History
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="aiTabsContent">
                        <!-- Chat Tab -->
                        <div class="tab-pane fade show active" id="chat" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Chat with AI</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="chat-messages" style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; margin-bottom: 15px;">
                                                <div class="text-muted text-center">
                                                    <i class="fas fa-robot fa-2x mb-2"></i>
                                                    <p>Mulai percakapan dengan AI Assistant</p>
                                                </div>
                                            </div>
                                            <form id="chat-form">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="chat-input" placeholder="Ketik pesan Anda...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">
                                                            <i class="fas fa-paper-plane"></i> Kirim
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6>Settings</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Context</label>
                                                <select class="form-control" id="chat-context">
                                                    <option value="general">General</option>
                                                    <option value="medical">Medical</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Model</label>
                                                <select class="form-control" id="chat-model">
                                                    <option value="">Default (GPT-3.5)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medical Analysis Tab -->
                        <div class="tab-pane fade" id="medical" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Medical Text Analysis</h5>
                                </div>
                                <div class="card-body">
                                    <form id="medical-form">
                                        <div class="form-group">
                                            <label>Medical Text</label>
                                            <textarea class="form-control" id="medical-text" rows="6" placeholder="Masukkan teks medis yang ingin dianalisis..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Analysis Type</label>
                                            <select class="form-control" id="analysis-type">
                                                <option value="general">General Analysis</option>
                                                <option value="diagnosis">Diagnosis Suggestion</option>
                                                <option value="treatment">Treatment Recommendation</option>
                                                <option value="summary">Summary</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-search"></i> Analyze
                                        </button>
                                    </form>
                                    <div id="medical-result" class="mt-3" style="display: none;">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6>Analysis Result</h6>
                                            </div>
                                            <div class="card-body" id="medical-result-content">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Report Generation Tab -->
                        <div class="tab-pane fade" id="report" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Generate Medical Report</h5>
                                </div>
                                <div class="card-body">
                                    <form id="report-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Patient Name</label>
                                                    <input type="text" class="form-control" id="patient-name" placeholder="Nama Pasien">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Age</label>
                                                    <input type="text" class="form-control" id="patient-age" placeholder="Umur">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Chief Complaint</label>
                                            <textarea class="form-control" id="patient-complaint" rows="3" placeholder="Keluhan utama pasien..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Examination Results</label>
                                            <textarea class="form-control" id="patient-examination" rows="4" placeholder="Hasil pemeriksaan..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-file-medical"></i> Generate Report
                                        </button>
                                    </form>
                                    <div id="report-result" class="mt-3" style="display: none;">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6>Generated Report</h6>
                                            </div>
                                            <div class="card-body" id="report-result-content">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- History Tab -->
                        <div class="tab-pane fade" id="history" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5>AI Interaction History</h5>
                                </div>
                                <div class="card-body">
                                    <div id="history-content">
                                        @if($recentInteractions->count() > 0)
                                            @foreach($recentInteractions as $interaction)
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <small class="text-muted">{{ $interaction->formatted_date }}</small>
                                                        <span class="badge badge-{{ $interaction->success ? 'success' : 'danger' }}">
                                                            {{ $interaction->context }}
                                                        </span>
                                                    </div>
                                                    <p class="mb-1"><strong>Q:</strong> {{ $interaction->truncated_message }}</p>
                                                    <p class="mb-0"><strong>A:</strong> {{ $interaction->truncated_response }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="text-center text-muted">
                                                <i class="fas fa-history fa-2x mb-2"></i>
                                                <p>Belum ada riwayat interaksi AI</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Load available models
    loadModels();

    // Chat form submission
    $('#chat-form').on('submit', function(e) {
        e.preventDefault();
        sendChatMessage();
    });

    // Medical analysis form
    $('#medical-form').on('submit', function(e) {
        e.preventDefault();
        analyzeMedicalText();
    });

    // Report generation form
    $('#report-form').on('submit', function(e) {
        e.preventDefault();
        generateReport();
    });
});

function testConnection() {
    $('#connection-status').show().removeClass('alert-success alert-danger').addClass('alert-info')
        .html('<i class="fas fa-spinner fa-spin"></i> Testing connection...');

    $.get('{{ route("ai.test-connection") }}')
        .done(function(response) {
            if (response.success) {
                $('#connection-status').removeClass('alert-info').addClass('alert-success')
                    .html('<i class="fas fa-check"></i> Connection successful! AI is ready to use.');
            } else {
                $('#connection-status').removeClass('alert-info').addClass('alert-danger')
                    .html('<i class="fas fa-times"></i> Connection failed: ' + (response.error || 'Unknown error'));
            }
        })
        .fail(function() {
            $('#connection-status').removeClass('alert-info').addClass('alert-danger')
                .html('<i class="fas fa-times"></i> Connection test failed. Please check your configuration.');
        });
}

function loadModels() {
    $.get('{{ route("ai.models") }}')
        .done(function(response) {
            if (response.success && response.models.length > 0) {
                const select = $('#chat-model');
                select.empty().append('<option value="">Default (GPT-3.5)</option>');
                response.models.forEach(function(model) {
                    select.append(`<option value="${model.id}">${model.id}</option>`);
                });
            }
        });
}

function sendChatMessage() {
    const message = $('#chat-input').val().trim();
    if (!message) return;

    const context = $('#chat-context').val();
    const model = $('#chat-model').val();

    // Add user message to chat
    addMessageToChat('user', message);
    $('#chat-input').val('');

    // Show loading
    addMessageToChat('ai', '<i class="fas fa-spinner fa-spin"></i> Thinking...');

    $.post('{{ route("ai.chat") }}', {
        message: message,
        context: context,
        model: model,
        _token: '{{ csrf_token() }}'
    })
    .done(function(response) {
        // Remove loading message
        $('#chat-messages .message:last').remove();
        
        if (response.success) {
            addMessageToChat('ai', response.message);
        } else {
            addMessageToChat('ai', 'Error: ' + (response.error || 'Unknown error'), 'error');
        }
    })
    .fail(function() {
        $('#chat-messages .message:last').remove();
        addMessageToChat('ai', 'Connection error. Please try again.', 'error');
    });
}

function addMessageToChat(sender, message, type = '') {
    const isUser = sender === 'user';
    const messageClass = type === 'error' ? 'alert-danger' : (isUser ? 'alert-primary' : 'alert-secondary');
    const icon = isUser ? 'fa-user' : 'fa-robot';
    
    const messageHtml = `
        <div class="message mb-2">
            <div class="alert ${messageClass}">
                <i class="fas ${icon} mr-2"></i>
                <strong>${isUser ? 'You' : 'AI'}:</strong> ${message}
            </div>
        </div>
    `;
    
    $('#chat-messages').append(messageHtml);
    $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
}

function analyzeMedicalText() {
    const text = $('#medical-text').val().trim();
    const analysisType = $('#analysis-type').val();
    
    if (!text) {
        alert('Please enter medical text to analyze.');
        return;
    }

    $('#medical-result').hide();
    
    $.post('{{ route("ai.analyze-medical") }}', {
        text: text,
        analysis_type: analysisType,
        _token: '{{ csrf_token() }}'
    })
    .done(function(response) {
        if (response.success) {
            $('#medical-result-content').html(response.message.replace(/\n/g, '<br>'));
            $('#medical-result').show();
        } else {
            alert('Error: ' + (response.error || 'Unknown error'));
        }
    })
    .fail(function() {
        alert('Connection error. Please try again.');
    });
}

function generateReport() {
    const patientData = {
        nama: $('#patient-name').val().trim(),
        umur: $('#patient-age').val().trim(),
        keluhan: $('#patient-complaint').val().trim(),
        pemeriksaan: $('#patient-examination').val().trim()
    };
    
    if (!patientData.nama) {
        alert('Please enter patient name.');
        return;
    }

    $('#report-result').hide();
    
    $.post('{{ route("ai.generate-report") }}', {
        patient_data: patientData,
        _token: '{{ csrf_token() }}'
    })
    .done(function(response) {
        if (response.success) {
            $('#report-result-content').html(response.message.replace(/\n/g, '<br>'));
            $('#report-result').show();
        } else {
            alert('Error: ' + (response.error || 'Unknown error'));
        }
    })
    .fail(function() {
        alert('Connection error. Please try again.');
    });
}
</script>
@endpush
@endsection
