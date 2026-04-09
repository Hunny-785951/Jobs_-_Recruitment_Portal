<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function create(Job $job)
    {
        return view('jobs.apply', compact('job'));
    }

    /**
     * STORE: Save the application and the PDF resume.
     */
    public function store(Request $request, Job $job)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'resume' => 'required|file|mimes:pdf|max:2048', 
            'cover_letter' => 'nullable|string'
        ]);

        try {
            // Stores the physical PDF file in the storage directory
            $resumePath = $request->file('resume')->store('resumes', 'public');

            // Stores the application text data in the MySQL 'applications' table
            $job->applications()->create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'resume_path' => $resumePath,
                'cover_letter' => $validated['cover_letter']
            ]);

            // 4. Redirect back with specific data for our custom pop-up modal
            return redirect()->route('jobs.show', $job->id)
                ->with('application_success', true)
                ->with('applicant_name', $validated['full_name'])
                ->with('job_title', $job->title)
                ->with('company_name', $job->company_name);

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Application failed to send: ' . $e->getMessage()]);
        }
    }
}