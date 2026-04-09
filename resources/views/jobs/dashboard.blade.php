@extends('layouts.app')

@section('content')
<style>
    /* ==========================================
       PREMIUM SAAS STYLING & ANIMATIONS
       ========================================== */
    :root {
        --primary-indigo: #4f46e5;
        --primary-violet: #7c3aed;
        --success-emerald: #10b981;
        --dark-slate: #0f172a;
        --light-slate: #64748b;
        --bg-soft: #f8fafc;
        --border-soft: #e2e8f0;
    }

    /* Smooth global transitions */
    .smooth-transition {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Top Statistics Cards */
    .stat-card {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 1.25rem;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 4px;
        background: linear-gradient(90deg, var(--primary-indigo), var(--primary-violet));
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .stat-card:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.1), 0 8px 10px -6px rgba(79, 70, 229, 0.1);
        border-color: rgba(79, 70, 229, 0.2);
    }
    .stat-card:hover::before {
        opacity: 1;
    }

    /* Icon Containers */
    .icon-box-primary {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.1));
        color: var(--primary-indigo);
    }
    .icon-box-success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
        color: var(--success-emerald);
    }

    /* Job Listing Cards */
    .job-card {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-left: 4px solid transparent;
    }
    .job-card:hover {
        border-left-color: var(--primary-indigo);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.05);
        transform: translateX(4px);
    }

    /* Gradient Buttons */
    .btn-gradient {
        background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet));
        color: white;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
    }
    .btn-gradient:hover {
        background: linear-gradient(135deg, var(--primary-violet), var(--primary-indigo));
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        color: white;
    }

    /* Table Enhancements */
    .applicant-table th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.8px;
        color: var(--light-slate);
        background-color: var(--bg-soft);
        border-bottom: 2px solid var(--border-soft);
    }
    .applicant-row {
        transition: background-color 0.2s ease;
    }
    .applicant-row:hover {
        background-color: #fcfcfd;
    }

    /* Action Buttons */
    .action-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .action-btn:hover {
        transform: translateY(-2px) scale(1.05);
    }

    /* Empty State Animation */
    .floating-icon {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
</style>

<div class="container py-5">
    
    {{-- Dashboard Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h1 class="fw-bold mb-1" style="color: var(--dark-slate);">Employer Portal</h1>
            <p class="fs-5 mb-0" style="color: var(--light-slate);">Manage active listings and review top talent.</p>
        </div>
        <div class="mt-4 mt-md-0">
            <a href="{{ route('jobs.create') }}" class="btn btn-gradient btn-lg rounded-pill fw-bold smooth-transition px-5 py-3">
                <i class="bi bi-plus-lg me-2"></i> Post New Job
            </a>
        </div>
    </div>

    {{-- Top Statistics Row --}}
    @php
        $totalJobs = $jobs->count();
        $totalApplicants = $jobs->sum(function($job) { return $job->applications->count(); });
    @endphp

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="stat-card smooth-transition p-4 p-lg-5">
                <div class="d-flex align-items-center">
                    <div class="icon-box-primary rounded-4 d-flex align-items-center justify-content-center me-4" style="width: 70px; height: 70px;">
                        <i class="bi bi-briefcase-fill fs-2"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-uppercase small tracking-wide" style="color: var(--light-slate); letter-spacing: 1px;">Active Listings</span>
                        <h2 class="fw-bold mb-0 display-5" style="color: var(--dark-slate); line-height: 1.1;">{{ $totalJobs }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card smooth-transition p-4 p-lg-5">
                <div class="d-flex align-items-center">
                    <div class="icon-box-success rounded-4 d-flex align-items-center justify-content-center me-4" style="width: 70px; height: 70px;">
                        <i class="bi bi-people-fill fs-2"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-uppercase small tracking-wide" style="color: var(--light-slate); letter-spacing: 1px;">Total Candidates</span>
                        <h2 class="fw-bold mb-0 display-5" style="color: var(--dark-slate); line-height: 1.1;">{{ $totalApplicants }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Active Jobs & Applicants Section --}}
    <h4 class="fw-bold mb-4" style="color: var(--dark-slate);">Your Job Openings</h4>

    @forelse($jobs as $job)
        <div class="card job-card rounded-4 mb-4 smooth-transition overflow-hidden">
            
            {{-- Job Header --}}
            <div class="card-body p-4 p-md-5 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
                <div class="mb-4 mb-lg-0">
                    <div class="d-flex align-items-center mb-2 gap-3">
                        <h4 class="fw-bold mb-0" style="color: var(--dark-slate);">{{ $job->title }}</h4>
                        <span class="badge rounded-pill fw-medium px-3 py-2" style="background: var(--bg-soft); color: var(--light-slate); border: 1px solid var(--border-soft);">
                            <i class="bi bi-clock me-1"></i> {{ $job->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-4 mt-3" style="color: var(--light-slate);">
                        <span class="d-flex align-items-center"><i class="bi bi-geo-alt fs-5 me-2" style="color: var(--primary-indigo);"></i> {{ $job->location }}</span>
                        <span class="d-flex align-items-center"><i class="bi bi-cash-stack fs-5 me-2" style="color: var(--success-emerald);"></i> {{ $job->salary_range ?? 'Not Disclosed' }}</span>
                    </div>
                </div>

                {{-- Applicant Count & Toggle Button --}}
                <div class="text-lg-end">
                    <div class="mb-3">
                        @if($job->applications->count() > 0)
                            <span class="badge rounded-pill px-4 py-2 fs-6 shadow-sm" style="background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet));">
                                {{ $job->applications->count() }} Applicants
                            </span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-4 py-2 fs-6">
                                0 Applicants
                            </span>
                        @endif
                    </div>
                    <button class="btn btn-outline-dark rounded-pill fw-bold btn-sm px-4 py-2 smooth-transition" data-bs-toggle="collapse" data-bs-target="#applicants-{{ $job->id }}">
                        View Candidates <i class="bi bi-chevron-expand ms-1"></i>
                    </button>
                </div>
            </div>

            {{-- Applicants Collapse Area --}}
            <div class="collapse {{ $loop->first && $job->applications->count() > 0 ? 'show' : '' }}" id="applicants-{{ $job->id }}">
                <div class="p-0 border-top" style="background-color: var(--bg-soft);">
                    
                    @if($job->applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table applicant-table mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-4 border-0">Candidate Info</th>
                                        <th class="py-4 border-0">Applied On</th>
                                        <th class="py-4 text-center border-0">Resume</th>
                                        <th class="px-5 py-4 text-end border-0">Cover Letter</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($job->applications as $app)
                                        <tr class="applicant-row border-bottom">
                                            <td class="px-5 py-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold text-white shadow-sm" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--dark-slate), var(--light-slate));">
                                                        {{ strtoupper(substr($app->full_name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold fs-6" style="color: var(--dark-slate);">{{ $app->full_name }}</div>
                                                        <div class="small mt-1" style="color: var(--light-slate);"><i class="bi bi-envelope me-1"></i>{{ $app->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4" style="color: var(--light-slate); font-weight: 500;">
                                                {{ $app->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="py-4 text-center">
                                                <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="btn btn-sm text-danger bg-danger bg-opacity-10 fw-bold rounded-pill px-4 action-btn">
                                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                                                </a>
                                            </td>
                                            <td class="px-5 py-4 text-end">
                                                @if($app->cover_letter)
                                                    <button class="btn btn-sm btn-outline-primary rounded-pill fw-bold px-4 action-btn" 
                                                            onclick="viewCoverLetter('{{ addslashes($app->full_name) }}', '{{ addslashes($app->cover_letter) }}')">
                                                        <i class="bi bi-envelope-open me-1"></i> Read
                                                    </button>
                                                @else
                                                    <span class="small fst-italic" style="color: #cbd5e1;">Not provided</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #cbd5e1;"></i>
                            <h6 class="fw-bold" style="color: var(--dark-slate);">No candidates yet</h6>
                            <p class="small mb-0" style="color: var(--light-slate);">Applications will appear here once submitted.</p>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    @empty
        {{-- Empty State (No Jobs Posted) --}}
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center" style="background: linear-gradient(180deg, #ffffff 0%, var(--bg-soft) 100%);">
            <div class="py-5">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-4 floating-icon shadow-sm" style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(79,70,229,0.1), rgba(124,58,237,0.1)); color: var(--primary-indigo);">
                    <i class="bi bi-rocket-takeoff fs-1"></i>
                </div>
                <h3 class="fw-bold mb-3" style="color: var(--dark-slate);">Ready to build your dream team?</h3>
                <p class="fs-5 mb-5 max-w-md mx-auto" style="color: var(--light-slate);">You haven't posted any jobs yet. Create your first listing to start attracting top-tier talent today.</p>
                <a href="{{ route('jobs.create') }}" class="btn btn-gradient btn-lg rounded-pill fw-bold px-5 py-3 smooth-transition">
                    Create Your First Job <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    @endforelse
    
    {{-- ========================================== --}}
    {{-- GLOBAL CANDIDATE DATA TABLE                --}}
    {{-- ========================================== --}}
    <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
        <h4 class="fw-bold mb-0" style="color: var(--dark-slate);">Recent Candidates</h4>
        <span class="badge rounded-pill" style="background: var(--bg-soft); color: var(--light-slate); border: 1px solid var(--border-soft);">
            {{ isset($allApplications) ? $allApplications->count() : 0 }} Total Applications
        </span>
    </div>

    <div class="card dashboard-table-card rounded-4 overflow-hidden mb-5">
        <div class="table-responsive">
            <table class="table applicant-table mb-0 align-middle">
                <thead style="background-color: var(--bg-soft);">
                    <tr>
                        <th class="ps-4 ps-md-5 py-4 border-0">Candidate Details</th>
                        <th class="py-4 border-0">Applied For (Job Role)</th>
                        <th class="py-4 border-0">Date Applied</th>
                        <th class="pe-4 pe-md-5 py-4 text-end border-0">Documents</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if(isset($allApplications) && $allApplications->count() > 0)
                        @foreach($allApplications as $app)
                            <tr class="applicant-row border-bottom">
                                
                                {{-- User Info Column --}}
                                <td class="ps-4 ps-md-5 py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold text-white shadow-sm" style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--primary-indigo), var(--primary-violet));">
                                            {{ strtoupper(substr($app->full_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold fs-6" style="color: var(--dark-slate);">{{ $app->full_name }}</div>
                                            <a href="mailto:{{ $app->email }}" class="small mt-1 text-decoration-none" style="color: var(--light-slate);">
                                                <i class="bi bi-envelope me-1"></i>{{ $app->email }}
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                {{-- Job Role Column --}}
                                <td class="py-4">
                                    <span class="fw-medium text-dark">{{ $app->job->title ?? 'Position Removed' }}</span>
                                    <div class="small mt-1" style="color: var(--light-slate);">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $app->job->location ?? 'N/A' }}
                                    </div>
                                </td>

                                {{-- Date Column --}}
                                <td class="py-4" style="color: var(--light-slate); font-weight: 500;">
                                    {{ $app->created_at->format('M d, Y') }}
                                    <div class="small mt-1 fw-normal opacity-75">{{ $app->created_at->diffForHumans() }}</div>
                                </td>

                                {{-- Action Buttons Column --}}
                                <td class="pe-4 pe-md-5 py-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if($app->cover_letter)
                                            <button class="btn btn-sm btn-light border rounded-pill fw-bold px-3 action-btn" 
                                                    style="color: var(--primary-indigo);"
                                                    onclick="viewCoverLetter('{{ addslashes($app->full_name) }}', '{{ addslashes($app->cover_letter) }}')">
                                                <i class="bi bi-text-paragraph me-1"></i> Read Note
                                            </button>
                                        @endif
                                        
                                        <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="btn btn-sm rounded-pill fw-bold px-3 shadow-sm action-btn" style="background-color: #fee2e2; color: #dc2626; border: 1px solid #fecaca;">
                                            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Resume
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Empty State --}}
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background-color: var(--bg-soft); color: var(--light-slate);">
                                    <i class="bi bi-inbox fs-2"></i>
                                </div>
                                <h6 class="fw-bold" style="color: var(--dark-slate);">No applications received yet</h6>
                                <p class="small mb-0" style="color: var(--light-slate);">Once candidates start applying, their data will appear here.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Global Cover Letter Modal --}}
<div class="modal fade" id="coverLetterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4" style="transform: scale(0.98); transition: transform 0.3s ease;">
            <div class="modal-header border-0 p-4 pb-3" style="background-color: var(--bg-soft);">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">
                        <i class="bi bi-envelope-open-fill"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" style="color: var(--dark-slate);">Cover Letter</h5>
                        <span class="small" style="color: var(--light-slate);" id="clCandidateName">Candidate Name</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-3">
                <div class="bg-white border rounded-4 p-4 shadow-sm">
                    <p class="lh-lg mb-0" id="clContent" style="white-space: pre-wrap; font-weight: 400; color: #334155; font-size: 0.95rem;"></p>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn rounded-pill px-4 fw-bold smooth-transition" style="background: var(--border-soft); color: var(--dark-slate);" data-bs-dismiss="modal">Close Reader</button>
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- WELCOME POP-UP MODAL (SIGNUP SUCCESS)      --}}
{{-- ========================================== --}}
@if(session('signup_success'))
    <div class="modal fade" id="welcomeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                
                {{-- Decorative Top Bar --}}
                <div class="py-2" style="background: linear-gradient(90deg, var(--primary-indigo), var(--primary-violet));"></div>

                <div class="modal-body p-5 text-center">
                    {{-- Animated Icon Container --}}
                    <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle floating-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(79,70,229,0.1), rgba(124,58,237,0.1)); color: var(--primary-violet);">
                        <i class="bi bi-stars fs-1"></i>
                    </div>

                    <h2 class="fw-bold mb-2" style="color: var(--dark-slate);">Welcome to CrestCareers!</h2>
                    <p class="fs-5 mb-4" style="color: var(--light-slate);">We're thrilled to have you here, <span class="fw-bold" style="color: var(--primary-indigo);">{{ session('user_name') }}</span>.</p>
                    
                    {{-- Role Badge --}}
                    <div class="rounded-4 p-3 mb-4" style="background-color: var(--bg-soft); border: 1px solid var(--border-soft);">
                        <span class="text-uppercase small fw-bold d-block mb-2" style="color: var(--light-slate); letter-spacing: 0.5px;">Account Type</span>
                        <span class="badge fs-6 px-4 py-2 rounded-pill shadow-sm" style="background: {{ session('user_role') == 'admin' ? 'linear-gradient(135deg, #0f172a, #334155)' : 'linear-gradient(135deg, var(--primary-indigo), var(--primary-violet))' }};">
                            <i class="bi {{ session('user_role') == 'admin' ? 'bi-building' : 'bi-person-badge' }} me-2"></i>
                            {{ session('user_role') == 'admin' ? 'Employer / Recruiter' : 'Job Seeker / Candidate' }}
                        </span>
                    </div>

                    <p class="small mb-4" style="color: var(--light-slate);">
                        @if(session('user_role') == 'admin')
                            You can now start posting job openings and finding the perfect talent for your team.
                        @else
                            You can now browse listings, track your applications, and reach your career peak.
                        @endif
                    </p>

                    <button type="button" class="btn btn-gradient btn-lg w-100 rounded-pill fw-bold shadow-sm smooth-transition" data-bs-dismiss="modal">
                        Get Started
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Auto-trigger the modal on page load --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
            welcomeModal.show();
        });
    </script>
@endif

{{-- Script for the Cover Letter Modal with Animation enhancement --}}
<script>
    function viewCoverLetter(name, content) {
        document.getElementById('clCandidateName').innerText = 'From: ' + name;
        document.getElementById('clContent').innerText = content;
        
        var modalEl = document.getElementById('coverLetterModal');
        var clModal = new bootstrap.Modal(modalEl);
        
        // Add subtle scale-in animation when opened
        modalEl.addEventListener('show.bs.modal', function () {
            modalEl.querySelector('.modal-content').style.transform = 'scale(1)';
        });
        modalEl.addEventListener('hide.bs.modal', function () {
            modalEl.querySelector('.modal-content').style.transform = 'scale(0.98)';
        });

        clModal.show();
    }
</script>
@endsection