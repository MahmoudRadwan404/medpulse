<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    //
protected $guarded='id';
    protected $fillable = [
        'name_en',
        'name_ar',
        'job_en',
        'job_ar',
        'medpulse_role_en',
        'medpulse_role_ar',
        'medpulse_role_description_en',
        'medpulse_role_description_ar',
        'current_job_en',
        'current_job_ar',
        'coverage_type_en',
        'coverage_type_ar',
        'evaluated_specialties_en',
        'evaluated_specialties_ar',
        'number_of_events',
        'description_en',
        'description_ar',
        'years_of_experience',
        'subspecialities_en',
        'membership_en',
        'subspecialities_ar',
        'membership_ar',
        'covaredEventsIds'
    ];

    protected $casts = [
        'evaluated_specialties_en' => 'array',
        'evaluated_specialties_ar' => 'array',
        'subspecialities_en' => 'array',
        'membership_en' => 'array',
        'covaredEventsIds' => 'array',
        'subspecialities_ar' => 'array',
        'membership_ar' => 'array',
        'number_of_events' => 'integer',
        'years_of_experience' => 'integer',
    ];

    /**
     * Get the contacts for the expert.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the videos for the expert.
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }
}
