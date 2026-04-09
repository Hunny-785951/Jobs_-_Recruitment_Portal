@extends('layouts.app')

@section('content')
<style>
    /* Premium Auth Styling */
    :root {
        --primary-indigo: #4f46e5;
        --primary-violet: #7c3aed;
        --dark-slate: #0f172a;
        --light-slate: #64748b;
        --bg-soft: #f8fafc;
        --border-soft: #e2e8f0;
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .auth-card {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05);
        transition: var(--transition-smooth);
    }
    
    .auth-card:hover {
        box-shadow: 0 30px 60px -15px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }

    /* Custom Form Inputs */
    .form-control-custom {
        background-color: var(--bg-soft);
        border: 1px solid transparent;
        color: var(--dark-slate);
        transition: var(--transition-smooth);
    }
    
    .form-control-custom:focus {
        background-color: #ffffff;
        border-color: rgba(124, 58, 237, 0.4);
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
    }

    /* Button Gradients */
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

    .btn-dark-gradient {
        background: linear-gradient(135deg, #0f172a, #334155);
        color: white;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.3);
        transition: var(--transition-smooth);
    }
    .btn-dark-gradient:hover {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.4);
        color: white;
    }

    /* Interactive Tab Styling */
    #registerTabs .nav-link {
        color: var(--light-slate) !important; 
        transition: var(--transition-smooth);
        border: 1px solid transparent;
    }
    #registerTabs .nav-link:hover:not(.active) {
        background-color: rgba(0,0,0,0.03);
    }
    
    /* Candidate Active Tab */
    #candidate-tab.active {
        background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet)) !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
    }
    
    /* Recruiter Active Tab */
    #recruiter-tab.active {
        background: linear-gradient(135deg, #0f172a, #334155) !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.25);
    }

    .link-custom {
        color: var(--primary-indigo);
        transition: var(--transition-smooth);
    }
    .link-custom:hover {
        color: var(--primary-violet);
    }
</style>

<div class="container py-5 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card auth-card rounded-4 overflow-hidden" style="max-width: 500px; width: 100%;">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold mb-1" style="color: var(--dark-slate);">Join CrestCareers</h3>
                <p class="small" style="color: var(--light-slate);">Choose your account type to get started.</p>
            </div>

            {{-- Role Selection Tabs (Pills) --}}
            <ul class="nav nav-pills nav-justified mb-4 rounded-pill p-1" style="background-color: var(--bg-soft); border: 1px solid var(--border-soft);" id="registerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill fw-bold" id="candidate-tab" data-bs-toggle="pill" data-bs-target="#candidate-register" type="button" role="tab" aria-selected="true">
                        <i class="bi bi-person me-1"></i> Job Seeker
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill fw-bold" id="recruiter-tab" data-bs-toggle="pill" data-bs-target="#recruiter-register" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-building me-1"></i> Employer
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="registerTabsContent">
                
                {{-- ========================================== --}}
                {{-- CANDIDATE (USER) REGISTRATION FORM         --}}
                {{-- ========================================== --}}
                <div class="tab-pane fade show active" id="candidate-register" role="tabpanel" aria-labelledby="candidate-tab">
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        {{-- Secretly tells the backend this is a normal user --}}
                        <input type="hidden" name="role" value="user">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-lg form-control-custom @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="john@example.com" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg form-control-custom @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Confirm</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg form-control-custom" placeholder="••••••••" required>
                            </div>
                            @error('password') <div class="text-danger small mt-1 w-100">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill fw-bold mb-4">
                            Create Candidate Account
                        </button>
                    </form>
                </div>

                {{-- ========================================== --}}
                {{-- RECRUITER (ADMIN) REGISTRATION FORM        --}}
                {{-- ========================================== --}}
                <div class="tab-pane fade" id="recruiter-register" role="tabpanel" aria-labelledby="recruiter-tab">
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        {{-- Secretly tells the backend this is a recruiter/admin --}}
                        <input type="hidden" name="role" value="admin">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Company Name</label>
                            <input type="text" name="name" class="form-control form-control-lg form-control-custom @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Acme Corp" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Work Email</label>
                            <input type="email" name="email" class="form-control form-control-lg form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="hr@acmecorp.com" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg form-control-custom @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Confirm</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg form-control-custom" placeholder="••••••••" required>
                            </div>
                            @error('password') <div class="text-danger small mt-1 w-100">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-dark-gradient btn-lg w-100 rounded-pill fw-bold mb-4">
                            Create Employer Account
                        </button>
                    </form>
                </div>

            </div>

            <p class="text-center small mb-0 mt-2" style="color: var(--light-slate);">
                Already have an account? <a href="{{ route('login') }}" class="fw-bold text-decoration-none link-custom">Log in here</a>
            </p>
            
        </div>
    </div>
</div>
@endsection