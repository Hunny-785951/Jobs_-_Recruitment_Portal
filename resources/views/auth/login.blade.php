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

    .icon-wrapper {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.1));
        color: var(--primary-violet);
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        transform: rotate(-3deg);
        transition: var(--transition-smooth);
    }
    .auth-card:hover .icon-wrapper {
        transform: rotate(0deg) scale(1.05);
    }

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
    
    .link-custom {
        color: var(--primary-indigo);
        transition: var(--transition-smooth);
    }
    .link-custom:hover {
        color: var(--primary-violet);
    }
</style>

<div class="container py-5 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card auth-card rounded-4 overflow-hidden" style="max-width: 450px; width: 100%;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="icon-wrapper shadow-sm">
                    <i class="bi bi-layers-fill fs-1"></i>
                </div>
                <h3 class="fw-bold" style="color: var(--dark-slate);">Welcome back</h3>
                <p class="small" style="color: var(--light-slate);">Enter your details to access your dashboard.</p>
            </div>

            <form method="POST" action="{{ route('login.authenticate') }}">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase" style="color: var(--light-slate); letter-spacing: 0.5px;">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-lg form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold small text-uppercase mb-0" style="color: var(--light-slate); letter-spacing: 0.5px;">Password</label>
                        <a href="#" class="small text-decoration-none fw-medium link-custom">Forgot password?</a>
                    </div>
                    <input type="password" name="password" class="form-control form-control-lg form-control-custom" required>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember" style="border-color: var(--border-soft);">
                    <label class="form-check-label small" style="color: var(--light-slate);" for="remember">Remember for 30 days</label>
                </div>

                <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill fw-bold mb-4">
                    Sign In
                </button>

                <p class="text-center small mb-0" style="color: var(--light-slate);">
                    Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-decoration-none link-custom">Sign up</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection