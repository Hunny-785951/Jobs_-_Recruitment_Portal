<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;

class JobController extends Controller
{
    /**
     * RETRIEVE: Fetch all jobs for the home page.
     */
    public function index()
    {
        // Eager load if you plan to show company/user details on the home page!
        $jobs = Job::latest()->get();
        return view('home', compact('jobs')); 
    }

    /**
     * CREATE: Show the form to post a new job.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * STORE: Save a new job to the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:50',
        ]);

        try {
            // Automatically assign to the logged-in user instead of hardcoding '1'
            $validated['user_id'] = auth()->id() ?? 1; 
            $validated['type'] = $request->type ?? 'Full-time';

            $job = Job::create($validated);
            
            return redirect()->route('home')
                ->with('job_created_success', true)
                ->with('created_job_title', $job->title)
                ->with('created_job_id', $job->id);
            
        } 
        catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Database Error: ' . $e->getMessage()]);
        }
    }
    
    /**
     * RETRIEVE: Fetch a single job's details.
     */
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    /**
     * RETRIEVE: Smart Dashboard (Handles both Admin and User views)
     */
    public function dashboard()
    {
        $user = auth()->user();

        // IF ADMIN: Show the Recruiter Dashboard
        if ($user->isAdmin()) {
            
            // DEVELOPER OVERRIDE: Fetch ALL jobs globally, bypassing user_id
            $jobs = Job::with('applications')
                       ->latest()
                       ->get();
            
            // DEVELOPER OVERRIDE: Fetch ALL applications globally.
            // Explicitly eager-load the 'job' relationship to eliminate the N+1 lazy loading problem!
            $allApplications = Application::with('job') 
                                          ->latest()
                                          ->get();
            
            return view('jobs.dashboard', compact('jobs', 'allApplications'));
        } 
        
        // IF NORMAL USER: Show the Candidate Dashboard
        else {
            // Eager loading already correctly applied here
            $applications = Application::where('email', $user->email)
                                       ->with('job')
                                       ->latest()
                                       ->get();

            return view('user.dashboard', compact('applications'));
        }
    }
}