@extends('layouts.app')

@section('content')
<style>
    /* Premium Data Visualization Styling */
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

    .main-card {
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05);
        border: 1px solid var(--border-soft);
        background: #ffffff;
    }

    .info-card {
        background-color: var(--bg-soft);
        transition: var(--transition-smooth);
        border: 1px solid transparent;
    }
    .info-card:hover {
        background-color: #ffffff !important;
        transform: translateY(-4px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.05);
        border-color: rgba(79, 70, 229, 0.2);
    }
    
    .company-logo-placeholder {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 800;
        border-radius: 1.25rem;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .apply-btn {
        background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet));
        color: white;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
        transition: var(--transition-smooth);
    }
    .apply-btn:hover {
        background: linear-gradient(135deg, var(--primary-violet), var(--primary-indigo));
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.4);
        color: white;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Back Navigation --}}
            <a href="{{ route('home') }}" class="btn btn-sm btn-light border rounded-pill fw-semibold mb-4 px-3 py-2" style="color: var(--light-slate); transition: var(--transition-smooth);">
                <i class="bi bi-arrow-left me-1"></i> Back to All Jobs
            </a>

            <div class="card main-card rounded-4 p-4 p-md-5 overflow-hidden position-relative">
                
                {{-- Decorative background element --}}
                <div class="position-absolute top-0 end-0 p-5" style="margin-top: -3rem; margin-right: -3rem; color: var(--bg-soft); opacity: 0.5;">
                    <i class="bi bi-briefcase-fill" style="font-size: 15rem;"></i>
                </div>

                {{-- Header Section --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 position-relative z-1">
                    <div class="d-flex align-items-center mb-4 mb-md-0">
                        {{-- Auto-generated Company Logo (First Letter) --}}
                        <div class="company-logo-placeholder me-4 flex-shrink-0">
                            {{ strtoupper(substr($job->company_name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="fw-bold mb-1" style="color: var(--dark-slate); font-size: 2.2rem; line-height: 1.1;">{{ $job->title }}</h1>
                            <p class="fs-5 fw-semibold mb-0" style="color: var(--primary-indigo);">{{ $job->company_name }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <span class="badge rounded-pill px-4 py-2 fs-6 fw-bold text-uppercase" style="background: rgba(79, 70, 229, 0.1); color: var(--primary-indigo); border: 1px solid rgba(79, 70, 229, 0.2);">
                            {{ $job->type }}
                        </span>
                    </div>
                </div>

                {{-- Metadata Grid --}}
                <div class="row g-3 mb-5 position-relative z-1">
                    {{-- Location --}}
                    <div class="col-sm-4">
                        <div class="info-card p-4 rounded-4 h-100 d-flex flex-column justify-content-center align-items-center text-center">
                            <i class="bi bi-geo-alt fs-3 mb-2" style="color: var(--primary-indigo);"></i>
                            <small class="text-uppercase fw-bold" style="color: var(--light-slate); letter-spacing: 0.5px; font-size: 0.75rem;">Location</small>
                            <span class="fw-bold fs-5 mt-1" style="color: var(--dark-slate);">{{ $job->location }}</span>
                        </div>
                    </div>
                    
                    {{-- Salary --}}
                    <div class="col-sm-4">
                        <div class="info-card p-4 rounded-4 h-100 d-flex flex-column justify-content-center align-items-center text-center">
                            <i class="bi bi-cash-stack fs-3 mb-2" style="color: var(--success-emerald);"></i>
                            <small class="text-uppercase fw-bold" style="color: var(--light-slate); letter-spacing: 0.5px; font-size: 0.75rem;">Salary Range</small>
                            <span class="fw-bold fs-5 mt-1" style="color: var(--dark-slate);">{{ $job->salary_range ?? 'Not Disclosed' }}</span>
                        </div>
                    </div>
                    
                    {{-- Posted Date --}}
                    <div class="col-sm-4">
                        <div class="info-card p-4 rounded-4 h-100 d-flex flex-column justify-content-center align-items-center text-center">
                            <i class="bi bi-calendar3 fs-3 mb-2" style="color: #f59e0b;"></i>
                            <small class="text-uppercase fw-bold" style="color: var(--light-slate); letter-spacing: 0.5px; font-size: 0.75rem;">Posted On</small>
                            <span class="fw-bold fs-5 mt-1" style="color: var(--dark-slate);">{{ $job->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <hr class="mb-5" style="border-color: var(--border-soft);">

                {{-- Job Description --}}
                <div class="job-description mb-5 position-relative z-1">
                    <h4 class="fw-bold mb-4 d-flex align-items-center" style="color: var(--dark-slate);">
                        <i class="bi bi-file-text me-2" style="color: var(--primary-violet);"></i> About the Role
                    </h4>
                    
                    <div class="lh-lg fs-5" style="color: #334155; font-weight: 400;">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                {{-- Call to Action --}}
                <div class="p-4 p-md-5 rounded-4 text-center mt-5" style="background-color: var(--bg-soft); border: 1px solid var(--border-soft);">
                    <h3 class="fw-bold mb-3" style="color: var(--dark-slate);">Ready to join {{ $job->company_name }}?</h3>
                    <p class="mb-4" style="color: var(--light-slate);">Submit your application directly to the hiring team.</p>
                    
                    <div class="d-grid col-md-8 mx-auto">
                        <a href="{{ route('applications.create', $job->id) }}" class="btn apply-btn btn-lg rounded-pill py-3 fw-bold fs-5">
                            <i class="bi bi-send-fill me-2"></i> Apply for this Position
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- SUCCESS POP-UP MODAL --}}
{{-- ========================================== --}}
@if(session('application_success'))
    <div class="modal fade" id="applicationSuccessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                
                {{-- Modal Header --}}
                <div class="modal-header border-0 p-4 pb-3" style="background-color: rgba(16, 185, 129, 0.05);">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-1 me-3" style="color: var(--success-emerald);"></i>
                        <div>
                            <h4 class="modal-title fw-bold mb-0" style="color: var(--dark-slate);">Success!</h4>
                            <span class="fw-bold" style="color: var(--success-emerald);">Application Submitted</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body p-4 pt-3">
                    <p class="fs-5 fw-bold" style="color: var(--dark-slate);">Hi {{ session('applicant_name') }},</p>
                    <p class="lh-lg" style="color: var(--light-slate);">Your application for <strong style="color: var(--dark-slate);">{{ session('job_title') }}</strong> at <strong style="color: var(--dark-slate);">{{ session('company_name') }}</strong> has been successfully received.</p>
                    
                    <div class="p-4 rounded-4 mt-4" style="background-color: var(--bg-soft); border: 1px solid var(--border-soft);">
                        <h6 class="fw-bold mb-2" style="color: var(--dark-slate);"><i class="bi bi-info-circle me-2" style="color: var(--primary-indigo);"></i>What’s next?</h6>
                        <p class="small mb-0 lh-base" style="color: var(--light-slate);">The hiring team will review your profile. If your qualifications match our needs, we will reach out via email within 3-5 business days.</p>
                    </div>
                </div>

                {{-- Modal Footer (Action Buttons) --}}
                <div class="modal-footer border-0 p-4 pt-0 d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill fw-bold px-4 w-100" style="border: 1px solid var(--border-soft); color: var(--light-slate);">
                        View My Applications
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-gradient rounded-pill fw-bold px-4 w-100 shadow-sm">
                        Back to Job Board
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Small script to automatically trigger the modal when the page loads --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var successModal = new bootstrap.Modal(document.getElementById('applicationSuccessModal'));
            successModal.show();
        });
    </script>
@endif
@endsection