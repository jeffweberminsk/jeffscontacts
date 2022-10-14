<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Employee::create([
            'first_name' => 'new',
            'last_name' => 'admin',
            'email' => 'new@admin.com',
            'admin' => 1,
            'edit' => 1,
            'create' => 1,
            'remove' => 1,
            'password' => Hash::make('newadmin'),
            ]);
        \App\Models\Customer::create([
            'first_name' => 'new',
            'last_name' => 'admin',
            'company' => 'contactsJW',
            'email' => 'new@admin.com',
            'password' => Hash::make('newadmin'),
            'email_verified_at' => now(),
            ]);
    }
}
