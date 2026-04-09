<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'user_id', 
        'title', 
        'company_name', 
        'description', 
        'location', 
        'salary_range', 
        'type'
    ];

    // A job belongs to a user (recruiter)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A job has many applications
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}