<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class Customer extends Authenticatable  implements MustVerifyEmail
{
    use Notifiable,CanResetPassword;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'company',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    //get all contacts that user saved 
    public function contacts()
    {
        return $this->belongsToMany(Contact::class)->withPivot('has_email', 'has_phone')->withTimestamps();
    }
    
    //get all lists that user has 
    public function lists()
    {
        return $this->hasMany(CustomerList::class);
    }

    public function has_contact($id)
    {
        if($this->contacts()->find($id))
            return true;
        else
            return false;
    } 
}
