<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'first_name' => [
                'required', 
                'string', 
                'max:255',],
            'last_name' => [
                'required', 
                'string', 
                'max:255',],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $admin = false;
        if(isset($input['admin'])){
            $admin = true;
            $edit = true;
            $create = true;
            $remove = true; 
        }
        else{
            $edit = false;
            if(isset($input['edit']))
                $edit = true;        
            $create = false;
            if(isset($input['create']))
                $edit = true;        
            $remove = false;
            if(isset($input['remove']))
                $remove = true;
        }

        return User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'admin' => $admin,
            'edit' => $edit,
            'create' => $create,
            'remove' => $remove,
            'password' => Hash::make($input['password']),
        ]);
    }
}
