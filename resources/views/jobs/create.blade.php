@extends('layouts.app')

@section('content')
<style>
    /* Premium SaaS Auth & Input Styling */
    :root {
        --primary-indigo: #4f46e5;
        --primary-violet: #7c3aed;
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

    .icon-wrapper {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.1));
        color: var(--primary-violet);
        transition: var(--transition-smooth);
    }

    .main-card {
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05);
        border: 1px solid var(--border-soft);
    }
    textarea.form-control-custom {
        resize: vertical;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- Global Error Alert --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4 rounded-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Please fix the errors below to post your job.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card main-card border-0 rounded-4 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom-0 pt-5 pb-0 px-5 text-center">
                    <div class="icon-wrapper rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-briefcase-fill fs-2"></i>
                    </div>
                    <h2 class="fw-bold mb-1" style="color: var(--dark-slate);">Post a New Opening</h2>
                    <p style="color: var(--light-slate);">Find the perfect candidate for your team</p>
                </div>

                <div class="card-body p-5 pt-4">
                    <form action="{{ route('jobs.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4 mb-4">
                            {{-- Job Title --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Job Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control form-control-lg form-control-custom @error('title') is-invalid @enderror" placeholder="e.g. Senior Laravel Developer" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Company Name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control form-control-lg form-control-custom @error('company_name') is-invalid @enderror" placeholder="e.g. Acme Corp" value="{{ old('company_name') }}" required>
                                @error('company_name')
                                    <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Location --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control form-control-lg form-control-custom @error('location') is-invalid @enderror" placeholder="Remote, NY, etc." value="{{ old('location') }}" required>
                                @error('location')
                                    <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Salary Range --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Salary Range</label>
                                <input type="text" name="salary_range" class="form-control form-control-lg form-control-custom @error('salary_range') is-invalid @enderror" placeholder="e.g. $80k - $120k" value="{{ old('salary_range') }}">
                                @error('salary_range')
                                    <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Job Type --}}
                            <div class="col-12">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Employment Type</label>
                                <select name="type" class="form-select form-select-lg form-select-custom @error('type') is-invalid @enderror">
                                    <option value="Full-time" {{ old('type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Freelance" {{ old('type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="Internship" {{ old('type') == 'Internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Job Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control form-control-lg form-control-custom @error('description') is-invalid @enderror" rows="6" placeholder="Describe the responsibilities, requirements, and perks..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="mb-4" style="border-color: var(--border-soft);">

                        <div class="d-flex gap-3">
                            <a href="{{ route('home') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-bold" style="border: 1px solid var(--border-soft); color: var(--light-slate);">Cancel</a>
                            <button type="submit" class="btn btn-gradient btn-lg rounded-pill px-5 fw-bold flex-grow-1">
                                <i class="bi bi-send-fill me-2"></i> Publish Job
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection