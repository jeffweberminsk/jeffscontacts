<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use App\Models\Customer;

class LoginController extends Controller
{

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login', ['not_admin' => true]);
    }

    /**
     * Show the application's registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function registrate(Request $request){
        //validate input
        Validator::make($request->all(), [
            'first_name' => [
                    'nullable',
                    'string', 
                    'max:255',
                ],
            'last_name' => [
                    'nullable', 
                    'string', 
                    'max:255',
                ],
            'last_name' => [
                    'nullable', 
                    'string', 
                    'max:255',
                ],
            'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(Customer::class),
                ],
            'password' => [
                     'required', 
                     'string',
                     'confirmed'
                 ],
        ])->validate();
        
        if(strpos($request->email , 'jeffscontacts') == false)
            abort(403);
         
        $customer = Customer::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'company' => $request['company'],
        ]);
        event(new Registered($customer));
        return redirect()->route('verification.notice');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->input('remember') == 'on' ? true : false;
        if (Auth::guard('customer')->attempt($credentials,$remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('login');
    }

}
