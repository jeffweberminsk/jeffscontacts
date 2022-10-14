<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerList extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lists';
    
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
        'name',
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
