<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    // The columns we are allowed to store data in
    protected $fillable = [
        'job_id', 
        'full_name', 
        'email', 
        'resume_path', 
        'cover_letter'
    ];

    // RETRIEVAL RELATIONSHIP: An application belongs to a specific job
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}