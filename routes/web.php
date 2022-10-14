<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Models\Contact;
use App\Models\Jeffcode;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Job;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], base_path('routes/admin.php'));
Route::group([], base_path('routes/main.php'));



