<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'main_company',
        'sub_company',
        'email_pattern',
    ];
    
    public function jeffcodes()
    {
        return $this->belongsToMany(Jeffcode::class);
    }
    
    public function offices()
    {
        return $this->hasMany(Office::class,'company_id');
    }
}