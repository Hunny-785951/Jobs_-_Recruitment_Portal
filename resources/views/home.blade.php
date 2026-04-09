@extends('layouts.app')

@section('content')
<style>
    /* ==========================================
       ULTRA-PREMIUM STARTUP AESTHETIC
       ========================================== */
    :root {
        --brand-primary: #4338ca; /* Deep Indigo */
        --brand-accent: #ec4899;  /* Vibrant Pink */
        --brand-glow: #8b5cf6;    /* Soft Purple */
        --surface-color: #ffffff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --border-light: rgba(0, 0, 0, 0.06);
    }

    body {
        background-color: #fafafa;
    }

    /* ------------------------------------------
       HERO SECTION: ANIMATED MESH GRADIENT
       ------------------------------------------ */
    .hero-section {
        position: relative;
        padding: 6rem 0 4rem;
        overflow: hidden;
    }

    /* The glowing animated blobs behind the text */
    .hero-bg-blob-1, .hero-bg-blob-2 {
        position: absolute;
        filter: blur(80px);
        z-index: 0;
        opacity: 0.6;
        animation: floatBlob 10s ease-in-out infinite alternate;
    }
    .hero-bg-blob-1 {
        top: -10%; left: 10%; width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(139,92,246,0.3) 0%, rgba(255,255,255,0) 70%);
    }
    .hero-bg-blob-2 {
        bottom: -20%; right: 10%; width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(236,72,153,0.2) 0%, rgba(255,255,255,0) 70%);
        animation-delay: -5s;
    }

    @keyframes floatBlob {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(30px, -50px) scale(1.1); }
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-weight: 800;
        font-size: clamp(2.5rem, 5vw, 4.5rem);
        line-height: 1.1;
        letter-spacing: -0.03em;
        color: var(--text-main);
    }

    .text-gradient {
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    /* ------------------------------------------
       BENTO-STYLE JOB CARDS
       ------------------------------------------ */
    .job-card {
        background: var(--surface-color);
        border: 1px solid var(--border-light);
        border-radius: 1.5rem;
        padding: 2rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    /* Hover effect: Smooth lift and colorful shadow */
    .job-card:hover {
        transform: translateY(-8px);
        border-color: rgba(139, 92, 246, 0.3);
        box-shadow: 0 25px 50px -12px rgba(67, 56, 202, 0.15);
    }

    /* Subtle gradient overlay on hover */
    .job-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(139,92,246,0.03) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: -1;
    }
    .job-card:hover::after {
        opacity: 1;
    }

    .job-badge {
        background: rgba(67, 56, 202, 0.06);
        color: var(--brand-primary);
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 100px;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border: 1px solid rgba(67, 56, 202, 0.1);
    }

    .job-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.3;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
    }

    .company-name {
        font-weight: 600;
        color: var(--brand-glow);
        font-size: 0.95rem;
    }

    /* Metadata Pills */
    .meta-pill {
        display: inline-flex;
        align-items: center;
        background: #f1f5f9;
        color: var(--text-muted);
        padding: 0.4rem 0.8rem;
        border-radius: 0.75rem;
        font-size: 0.8rem;
        font-weight: 600;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .meta-pill i {
        margin-right: 0.4rem;
        font-size: 0.9rem;
    }

    /* Action Button inside card */
    .card-btn {
        margin-top: auto;
        width: 100%;
        padding: 0.8rem;
        border-radius: 1rem;
        font-weight: 700;
        background: #f8fafc;
        color: var(--text-main);
        border: 1px solid var(--border-light);
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .job-card:hover .card-btn {
        background: var(--text-main);
        color: white;
        border-color: var(--text-main);
    }

    .card-btn i {
        transition: transform 0.3s ease;
    }
    .job-card:hover .card-btn i {
        transform: translateX(4px);
    }

    /* ------------------------------------------
       EMPTY STATE & MODALS (GLASSMORPHISM)
       ------------------------------------------ */
    .empty-glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.8);
        border-radius: 2rem;
        padding: 4rem 2rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.02);
    }

    .glass-modal {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border-radius: 1.5rem;
        border: 1px solid rgba(255,255,255,0.5);
    }
</style>

{{-- Animated Background Blobs --}}
<div class="hero-bg-blob-1"></div>
<div class="hero-bg-blob-2"></div>

<div class="container py-4 position-relative z-1">
    
    {{-- ALERT MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-dismissible fade show shadow-sm border-0 mb-4 rounded-4 d-flex align-items-center" style="background: #ecfdf5; color: #059669; border: 1px solid #10b981 !important;" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i> 
            <span class="fw-bold">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-dismissible fade show shadow-sm border-0 mb-4 rounded-4" style="background: #fef2f2; color: #dc2626; border: 1px solid #f87171 !important;" role="alert">
            <ul class="mb-0 fw-medium">
                @foreach($errors->all() as $error)
                    <li class="mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Hero Section --}}
    <div class="hero-section text-center">
        <div class="hero-content mx-auto" style="max-width: 800px;">
            <div class="badge rounded-pill mb-4 py-2 px-3 fw-bold" style="background: rgba(236, 72, 153, 0.1); color: var(--brand-accent); border: 1px solid rgba(236, 72, 153, 0.2);">
                <i class="bi bi-stars me-1"></i> Discover Your Future
            </div>
            <h1 class="hero-title mb-4">
                Find your next <br><span class="text-gradient">Great Opportunity.</span>
            </h1>
            <p class="fs-5 text-muted mb-5 px-md-5">We connect elite talent with the world's most innovative companies. Your next career breakthrough starts right here.</p>
        </div>
    </div>

    {{-- Job Board Grid --}}
    <div class="row g-4 mb-5">
        @forelse($jobs as $job)
            <div class="col-md-6 col-lg-4">
                <div class="job-card">
                    
                    {{-- Top row: Type & Time --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="job-badge text-uppercase">
                            {{ $job->type }}
                        </span>
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background: #f8fafc; color: var(--text-muted);" data-bs-toggle="tooltip" title="Posted {{ $job->created_at->diffForHumans() }}">
                            <i class="bi bi-bookmark-plus"></i>
                        </div>
                    </div>

                    {{-- Title & Company --}}
                    <div class="mb-4">
                        <div class="company-name text-uppercase tracking-wider mb-1"><i class="bi bi-buildings me-1"></i> {{ $job->company_name }}</div>
                        <h4 class="job-title">{{ $job->title }}</h4>
                    </div>

                    {{-- Metadata Row --}}
                    <div class="d-flex flex-wrap mb-4">
                        <div class="meta-pill">
                            <i class="bi bi-geo-alt-fill text-primary"></i> {{ $job->location }}
                        </div>
                        @if($job->salary_range)
                            <div class="meta-pill">
                                <i class="bi bi-cash-stack text-success"></i> {{ $job->salary_range }}
                            </div>
                        @endif
                    </div>

                    {{-- Action Button --}}
                    <a href="{{ route('jobs.show', $job->id) }}" class="card-btn stretched-link">
                        View Details <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="empty-glass mx-auto" style="max-width: 600px;">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent)); color: white;">
                        <i class="bi bi-rocket-takeoff fs-1"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-3">The board is empty</h2>
                    <p class="text-muted fs-5 mb-5 px-3">Be the pioneer. Post the very first open position on the platform and attract top-tier talent instantly.</p>
                    <a href="{{ url('/jobs/create') }}" class="btn btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg" style="background: var(--text-main); color: white;">
                        <i class="bi bi-plus-lg me-2"></i> Post Your First Job
                    </a>
                </div>
            </div>
        @endforelse 
    </div>
</div>

{{-- ========================================== --}}
{{-- JOB CREATED SUCCESS POP-UP (RECRUITER) --}}
{{-- ========================================== --}}
@if(session('job_created_success'))
    <div class="modal fade" id="jobCreatedModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg glass-modal overflow-hidden">
                
                {{-- Decorative Top Bar --}}
                <div class="py-1" style="background: linear-gradient(90deg, var(--brand-primary), var(--brand-accent));"></div>

                {{-- Modal Header --}}
                <div class="modal-header border-0 p-5 pb-0">
                    <div class="d-flex flex-column align-items-center text-center w-100">
                        <div class="rounded-circle d-flex justify-content-center align-items-center mb-4 shadow-sm" style="width: 80px; height: 80px; background: #ecfdf5; color: #10b981;">
                            <i class="bi bi-check-lg" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="modal-title fw-bold" style="color: var(--text-main);">Job Posted Successfully!</h3>
                        <p class="fs-5 mt-2 mb-0" style="color: var(--text-muted);">Your listing for <strong style="color: var(--brand-primary);">"{{ session('created_job_title') }}"</strong> is now live.</p>
                    </div>
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body p-5">
                    <div class="row g-4">
                        {{-- Share Actions --}}
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 h-100" style="background: rgba(248, 250, 252, 0.8); border: 1px solid var(--border-light);">
                                <h6 class="fw-bold mb-3" style="color: var(--text-main);">Share Your Listing</h6>
                                <div class="d-grid gap-2">
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('jobs.show', session('created_job_id'))) }}" target="_blank" class="btn fw-bold rounded-pill text-start" style="background-color: #e0e7ff; color: #4338ca;">
                                        <i class="bi bi-linkedin me-2"></i> Post to LinkedIn
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode('We are hiring a ' . session('created_job_title') . '! Apply here: ' . route('jobs.show', session('created_job_id'))) }}" target="_blank" class="btn fw-bold rounded-pill text-start" style="background-color: #f1f5f9; color: #0f172a;">
                                        <i class="bi bi-twitter-x me-2"></i> Share on X
                                    </a>
                                    <button onclick="copyJobLink('{{ route('jobs.show', session('created_job_id')) }}', this)" class="btn fw-bold rounded-pill text-start" style="background-color: #ffffff; color: var(--text-main); border: 1px solid var(--border-light);">
                                        <i class="bi bi-link-45deg me-2 fs-5"></i> Copy Direct Link
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Promote Action --}}
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 h-100 d-flex flex-column justify-content-between" style="background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1px solid #fde68a;">
                                <div>
                                    <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" style="background: #fef08a; color: #b45309; font-weight: 700; font-size: 0.8rem;">
                                        <i class="bi bi-lightning-charge-fill me-1"></i> PREMIUM
                                    </div>
                                    <h5 class="fw-bold" style="color: #92400e;">Promote Listing</h5>
                                    <p class="small mb-4" style="color: #b45309; line-height: 1.5;">Boost this post to reach 3x more premium candidates across our partner networks.</p>
                                </div>
                                <button class="btn fw-bold rounded-pill w-100 shadow-sm" style="background-color: #f59e0b; color: white; padding: 0.8rem;">
                                    Boost Post Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="modal-footer border-0 p-5 pt-0 d-flex gap-3 justify-content-center">
                    <a href="{{ route('dashboard') }}" class="btn rounded-pill fw-bold px-5 py-3" style="background: #f1f5f9; color: var(--text-main);">
                        Go to Dashboard
                    </a>
                    <a href="{{ route('jobs.create') }}" class="btn rounded-pill fw-bold px-5 py-3 shadow-sm" style="background: var(--text-main); color: white;">
                        <i class="bi bi-plus-lg me-2"></i> Post Another
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalEl = document.getElementById('jobCreatedModal');
            var jobModal = new bootstrap.Modal(modalEl);
            jobModal.show();
            
            // Enable tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });

        function copyJobLink(url, buttonElement) {
            navigator.clipboard.writeText(url).then(function() {
                let originalHTML = buttonElement.innerHTML;
                buttonElement.innerHTML = '<i class="bi bi-check2-all me-2 fs-5"></i> Link Copied!';
                buttonElement.style.backgroundColor = '#10b981';
                buttonElement.style.color = 'white';
                
                setTimeout(function() {
                    buttonElement.innerHTML = originalHTML;
                    buttonElement.style.backgroundColor = '#ffffff';
                    buttonElement.style.color = 'var(--text-main)';
                }, 2000);
            });
        }
    </script>
@endif
@endsection