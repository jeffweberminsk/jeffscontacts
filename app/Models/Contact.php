<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Contact extends Model
{
    use Sluggable;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'description'
            ]
        ];
    }

    public function jeffcodes()
    {
        return $this->belongsToMany(Jeffcode::class);
    }

    public function getFullnameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function getDescriptionAttribute()
    {
        $description = $this->fullname." ";
        if ($this->job_id)
            $description .= Job::find($this->job_id)->job." ";
        if ($this->company_id){
            $company = Company::find($this->company_id);
            if($company){
                if ($company->sub_company)
                    $description .= " ".$company->sub_company." ";    
                else
                    $description .= " ".$company->main_company." ";
            }
        }
        if ($this->country)
            $description .= $this->country;
        return $description;
    }
}
