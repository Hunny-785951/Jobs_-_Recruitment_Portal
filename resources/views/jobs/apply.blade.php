@extends('layouts.app')

@section('content')
<style>
    /* Premium SaaS Auth & Input Styling */
    :root {
        --primary-indigo: #4f46e5;
        --primary-violet: #7c3aed;
        --success-emerald: #10b981;
        --dark-slate: #0f172a;
        --light-slate: #64748b;
        --bg-soft: #f8fafc;
        --border-soft: #e2e8f0;
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control-custom, .form-select-custom {
        background-color: var(--bg-soft);
        border: 1px solid transparent;
        color: var(--dark-slate);
        transition: var(--transition-smooth);
    }
    
    .form-control-custom:focus, .form-select-custom:focus {
        background-color: #ffffff;
        border-color: rgba(124, 58, 237, 0.4) !important;
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1) !important;
    }

    .btn-gradient {
        background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet));
        color: white;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
        transition: var(--transition-smooth);
    }
    .btn-gradient:hover {
        background: linear-gradient(135deg, var(--primary-violet), var(--primary-indigo));
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        color: white;
    }

    .file-upload-wrapper {
        position: relative;
        border: 2px dashed var(--border-soft);
        border-radius: 1rem;
        background-color: var(--bg-soft);
        transition: var(--transition-smooth);
    }
    
    .file-upload-wrapper:hover {
        border-color: var(--primary-indigo) !important;
        background-color: rgba(79, 70, 229, 0.02) !important;
        transform: translateY(-2px);
    }

    .icon-wrapper {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.1));
        color: var(--primary-violet);
        transition: var(--transition-smooth);
    }

    .main-card {
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05);
        border: 1px solid var(--border-soft);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            
            {{-- Back Navigation --}}
            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-light border rounded-pill fw-semibold mb-4 px-3 py-2" style="color: var(--light-slate); transition: var(--transition-smooth);">
                <i class="bi bi-arrow-left me-1"></i> Back to Job Details
            </a>

            {{-- Global Error Alert --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4 rounded-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Please fix the errors below to submit your application.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card main-card border-0 rounded-4 overflow-hidden bg-white">
                {{-- Header --}}
                <div class="card-header bg-white border-bottom-0 pt-5 pb-3 px-4 px-md-5 text-center">
                    <div class="icon-wrapper rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-send-check-fill fs-2"></i>
                    </div>
                    <h2 class="fw-bold mb-1" style="color: var(--dark-slate);">Submit Application</h2>
                    <p class="fs-5" style="color: var(--light-slate);">Applying for <span class="fw-bold" style="color: var(--primary-indigo);">{{ $job->title }}</span> at {{ $job->company_name }}</p>
                </div>

                <div class="card-body p-4 p-md-5 pt-0">
                    <form action="{{ route('applications.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Full Name --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control form-control-lg form-control-custom @error('full_name') is-invalid @enderror" placeholder="e.g. Jane Doe" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email Address --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg form-control-custom @error('email') is-invalid @enderror" placeholder="jane@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ========================================== --}}
                        {{-- RESUME UPLOAD & LIVE PREVIEW               --}}
                        {{-- ========================================== --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Resume / CV <span class="text-danger">*</span></label>
                            
                            {{-- The Dropzone --}}
                            <div class="file-upload-wrapper p-4 text-center @error('resume') border-danger bg-danger bg-opacity-10 @enderror" id="dropZone" style="position: relative; overflow: hidden;">
                                
                                {{-- The actual file input --}}
                                <input type="file" name="resume" id="resumeInput" accept=".pdf" required
                                       style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">
                                
                                {{-- The UI Text --}}
                                <div id="uploadText" style="position: relative; z-index: 5; pointer-events: none;">
                                    <i class="bi bi-cloud-arrow-up-fill display-5 mb-2 d-block" style="color: var(--primary-violet);"></i>
                                    <span class="fw-bold d-block fs-5" style="color: var(--dark-slate);">Click to upload or drag and drop</span>
                                    <span class="small" style="color: var(--light-slate);">Only PDF files are accepted (Max: 2MB)</span>
                                </div>
                            </div>
                            
                            @error('resume')
                                <div class="text-danger fw-medium small mt-2"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror

                            {{-- The PDF Preview Container --}}
                            <div id="pdfPreviewContainer" class="mt-4 d-none">
                                <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                                    <span class="fw-bold" style="color: var(--success-emerald);"><i class="bi bi-file-earmark-pdf-fill me-2"></i>Attached: <span id="previewFileName" style="color: var(--dark-slate);"></span></span>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" id="removeFileBtn">
                                        <i class="bi bi-trash-fill me-1"></i> Remove
                                    </button>
                                </div>
                                <iframe id="pdfPreviewFrame" class="w-100 rounded-4 border shadow-sm" style="height: 500px; border-color: var(--border-soft);" src=""></iframe>
                            </div>
                        </div>

                        {{-- Cover Letter --}}
                        <div class="mb-5">
                            <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Cover Letter <span class="fw-normal" style="opacity: 0.7;">(Optional)</span></label>
                            <textarea name="cover_letter" class="form-control form-control-lg form-control-custom @error('cover_letter') is-invalid @enderror" rows="5" placeholder="Why are you a great fit for this role?">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <div class="invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="mb-4" style="border-color: var(--border-soft);">

                        {{-- Submit Action --}}
                        <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill py-3 fw-bold">
                            <i class="bi bi-send-fill me-2"></i> Send Application
                        </button>
                    </form>
                </div>
            </div>
            
            <p class="text-center small mt-4" style="color: var(--light-slate);">
                <i class="bi bi-shield-lock-fill me-1"></i> Your information is secure and will only be shared with the hiring team.
            </p>
        </div>
    </div>
</div>
{{-- JavaScript for Upload & Preview Logic --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.getElementById('resumeInput');
        const uploadText = document.getElementById('uploadText');
        const dropZone = document.getElementById('dropZone');
        const pdfPreviewContainer = document.getElementById('pdfPreviewContainer');
        const pdfPreviewFrame = document.getElementById('pdfPreviewFrame');
        const previewFileName = document.getElementById('previewFileName');
        const removeFileBtn = document.getElementById('removeFileBtn');

        // Save the original text to restore it later
        const originalText = uploadText.innerHTML;

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                if(file.type === "application/pdf" || file.name.toLowerCase().endsWith('.pdf')) {
                    
                    uploadText.innerHTML = `
                        <i class="bi bi-file-earmark-pdf-fill text-danger display-5 mb-2 d-block"></i>
                        <span class="fw-bold d-block fs-5" style="color: var(--success-emerald);"><i class="bi bi-check-circle-fill me-1"></i> File Attached!</span>
                        <span class="fw-bold mt-2 d-block fs-6" style="color: var(--dark-slate);">${file.name}</span>
                        <span class="small mt-1 d-block" style="color: var(--light-slate);">Click box to change file</span>
                    `;
                    
                    dropZone.style.borderColor = '#10b981';
                    dropZone.style.backgroundColor = 'rgba(16, 185, 129, 0.05)';
                    dropZone.style.borderStyle = 'solid';

                    const fileUrl = URL.createObjectURL(file);
                    pdfPreviewContainer.classList.remove('d-none');
                    pdfPreviewFrame.src = fileUrl;
                    previewFileName.textContent = file.name;
                    
                } else {
                    alert("Please upload a valid PDF document.");
                    resetUpload();
                }
            }
        });

        removeFileBtn.addEventListener('click', function() {
            resetUpload();
        });

        function resetUpload() {
            fileInput.value = ""; 
            pdfPreviewContainer.classList.add('d-none'); 
            pdfPreviewFrame.src = ""; 
            uploadText.innerHTML = originalText; 
            dropZone.style.borderColor = 'var(--border-soft)';
            dropZone.style.backgroundColor = 'var(--bg-soft)';
            dropZone.style.borderStyle = 'dashed';
        }
    });
</script>
@endsection