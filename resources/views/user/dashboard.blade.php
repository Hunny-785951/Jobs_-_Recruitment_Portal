@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    {{-- Candidate Dashboard Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h1 class="fw-bold mb-1 text-dark">My Applications</h1>
            <p class="text-muted fs-5 mb-0">Track the status of your job applications.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill fw-bold px-4">
                <i class="bi bi-search me-2"></i> Browse More Jobs
            </a>
        </div>
    </div>

    {{-- Applications List --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        @if($applications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-uppercase text-muted small fw-bold">Job Details</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Company</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Applied On</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold text-center">Status</th>
                            <th class="px-4 py-3 text-uppercase text-muted small fw-bold text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="fw-bold text-dark fs-6">{{ $app->job->title }}</div>
                                    <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $app->job->location }}</div>
                                </td>
                                <td class="py-4 fw-medium text-dark">
                                    {{ $app->job->company_name }}
                                </td>
                                <td class="py-4 text-muted">
                                    {{ $app->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-4 text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2">
                                        <i class="bi bi-check-circle-fill me-1"></i> Submitted
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-end">
                                    <a href="{{ route('jobs.show', $app->job->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-medium text-dark hover-primary">
                                        View Listing
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-5">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                    <i class="bi bi-file-earmark-text fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">No applications yet</h4>
                <p class="text-muted mb-4">You haven't applied to any jobs yet. Start exploring!</p>
                <a href="{{ route('home') }}" class="btn btn-primary rounded-pill fw-bold px-4 shadow-sm">
                    Find Your Next Role
                </a>
            </div>
        @endif
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
                    <div class="py-2 bg-primary"></div>

                    <div class="modal-body p-5 text-center">
                        {{-- Animated Icon Container --}}
                        <div class="mb-4 d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-stars fs-1"></i>
                        </div>

                        <h2 class="fw-bold text-dark mb-2">Welcome to CrestCareers!</h2>
                        <p class="text-muted fs-5 mb-4">We're thrilled to have you here, <span class="text-primary fw-bold">{{ session('user_name') }}</span>.</p>
                        
                        {{-- Role Badge --}}
                        <div class="bg-light rounded-4 p-3 mb-4 border">
                            <span class="text-uppercase small fw-bold text-muted d-block mb-1">Account Type</span>
                            <span class="badge {{ session('user_role') == 'admin' ? 'bg-dark' : 'bg-primary' }} fs-6 px-4 py-2 rounded-pill">
                                <i class="bi {{ session('user_role') == 'admin' ? 'bi-building' : 'bi-person-badge' }} me-2"></i>
                                {{ session('user_role') == 'admin' ? 'Employer / Recruiter' : 'Job Seeker / Candidate' }}
                            </span>
                        </div>

                        <p class="small text-muted mb-4">
                            @if(session('user_role') == 'admin')
                                You can now start posting job openings and finding the perfect talent for your team.
                            @else
                                You can now browse listings, track your applications, and reach your career peak.
                            @endif
                        </p>

                        <button type="button" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm" data-bs-dismiss="modal">
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
@endsection