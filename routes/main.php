<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Models\Contact;
use App\Models\Jeffcode;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Job;
use App\Models\Office;
use App\Models\CustomerList;
use App\Http\Controllers\LoginController;

//site routes accesible to customers
Route::group(['middleware' => ['auth:customer', 'verified']], function () {
    
//show home page
Route::get('/', function () {
    $jeffcodes = Jeffcode::orderBy('jeffcode', 'asc')->get();
    return view('main.search', ['jeffcodes' => $jeffcodes]);
});

Route::get('/plans', function () {
    return view('main.plans');
});

//routes to My Account pages-Jeff will change later
Route::group(['prefix' => 'customer',], function () {
    
    //sets the default page when user clicks the My Accounts button. this page is My Profile 
    Route::get('/', function () {
        return redirect('customer/profile');
    });

    //show user's My Profile page
    Route::get('/profile', function (Request $request) {
        
        return view('main.customer.profile');
    });

    //show user's My Contacts page
    Route::get('/contacts', function (Request $request) {
        
        // Boris is preparing a statement and the statement contains orders of how to get data from the database
        $query = Auth::guard('customer')->user()->contacts()
        ->leftJoin('companies', 'companies.id', '=', 'contacts.company_id');
    
        //define the columns that we need to locate in the contacts table
        $query = $query->select([
            'contacts.id',
            'contacts.slug',
            'contacts.first_name',
            'contacts.last_name',
            'contacts.work_email',
            'contacts.personal_email',
            'contacts.photo',
            
            //'has_email',
            'companies.main_company as main_company',
            'companies.sub_company as sub_company']);
    
        //order contacts
        $query = $query->orderBy('last_name', 'asc')->orderBy('first_name', 'asc');
        
        //using paginate to auto divide results into groups of 20
        $results = $query->paginate(20);
        $jeffcodes = Jeffcode::orderBy('jeffcode', 'asc')->get();
        //return $query;
        return view('main.customer.contacts', 
        [
            'results' => $results, 
            'input' => $request->all(), 
        ]);
    });

    //show customer's lists page
    Route::get('/lists', function (Request $request) {            
        $lists = Auth::guard('customer')->user()->lists()->get();
        //if customer doesn't have any lists
        if(count($lists) == 0)
            return view('main.customer.lists');
            
        //if customer selected list get contacts from that list else get firt list
        if (isset($request->list)){
           $query = Auth::guard('customer')->user()->lists()
           ->find($request->list);
           
        }else{
            $query = Auth::guard('customer')->user()->lists()
            ->first();
        }
        //get the id of selected list
        $seleted_list = $query->id;
        //selecting what data we need to send
        $query = $query->contacts()->select([
            'contacts.id',
            'contacts.slug',
            'contacts.first_name',
            'contacts.last_name',
            'contacts.work_email',
            'contacts.personal_email',
            'contacts.photo',
            ]);
    
        //order contacts
        $query = $query->orderBy('last_name', 'asc')->orderBy('first_name', 'asc');
        //using paginate to auto divide resolts into groups of 20
        $results = $query->paginate(20);

        return view('main.customer.lists',[
            'lists' => $lists,
            'seleted_list' => $seleted_list,
            'results' => $results, 
            'input' => $request->all(), 
            ]);
    });

    //show customer's plans page
    Route::get('/plan', function (Request $request) {
        
        return view('main.customer.plan');
    });

    //show customer's apps page
    Route::get('/apps', function (Request $request) {
        
        return view('main.customer.apps');
    });

    //show customer's settings page
    Route::get('/settings', function (Request $request) {
        
        return view('main.customer.settings');
    });

    //add contacts to customer's contacts
    Route::get('/addconact/{conact_id}', function ($conact_id) {
        Auth::guard('customer')->user()->contacts()->attach($conact_id);
        return ['success' => true, 'message' => 'contact added'];
    });

    //remove contact from customer's contacts
    Route::get('/removeconact/{conact_id}', function ($conact_id){
        Auth::guard('customer')->user()->contacts()->detach($conact_id);
        return ['success' => true, 'message' => 'contact removed'];
    });

    //create new contact list 
    Route::post('/newlist', function (Request $request) {
        //$request->validate(['' => 'required|string|max:255']);
        Auth::guard('customer')->user()->lists()->create([
            'name' => $request->name,
        ]);
        return redirect('customer/lists');
    });

    //delete selected list
    Route::post('/deletelist', function (Request $request) {
        $message = 'list deleted';
        try{
            CustomerList::destroy($request->list);
        }catch(Exception $e){
            $message = 'list deletion failed';
        }finally {
            return redirect('customer/lists')->with('status', $message);
        }
    });

    //add to customer's list 
    Route::post('/addTolist', function (Request $request) {
        $list = Auth::guard('customer')->user()->lists()
        ->where('name',$request->list)->firstOrFail();
        $list->contacts()->attach($request->contacts);
        return ['success' => true, 'message' => 'success'];
    });

});

Route::get('/search', function (Request $request) {

    $query = Contact::query()
    ->leftJoin('companies', 'companies.id', '=', 'contacts.company_id')->leftJoin('jobs', 'jobs.id', '=', 'contacts.job_id');


    //selecting what data we need to send
    $query = $query->select([
        'contacts.id',
        'contacts.slug',
        'contacts.first_name',
        'contacts.last_name',
        'contacts.work_email',
        'contacts.personal_email',
        'contacts.photo',
        'companies.main_company as main_company',
        'companies.sub_company as sub_company']);
   
    //setting search parametrs
    if($value = $request->input('job'))
        $query = $query->where('jobs.job','like', '%'.$value.'%');
    if($value = $request->input('company')){
        $query = $query->where(function ($query) use ($value) {
            $query = $query->where('companies.main_company','like', '%'.$value.'%')
            ->orWhere('companies.sub_company','like', '%'.$value.'%')
            ->orWhere('contacts.company','like', '%'.$value.'%')
            ->orWhere('contacts.sub_company','like', '%'.$value.'%');
        });
    }
    if($value = $request->input('city'))
        $query = $query->where('city','like', '%'.$value.'%');
    if($value = $request->input('country'))
        $query = $query->where('country','like', '%'.$value.'%');
        
    if ($value = $request->input('jeffcodes')){
        foreach($value as $code)
            $query = $query->whereIn('contacts.id', DB::table('contact_jeffcode')->select('contact_id')->where('jeffcode_id',$code));
    }
    if($value = $request->input('name')){
        foreach(explode(" ", $value) as $word )            
            $query = $query->where(function ($query) use ($word) {
                $query->where('first_name','like', '%'.$word.'%')
                ->orWhere('last_name','like', '%'.$word.'%');  
            });  
    }

    //show only contacts that are ready
    $query = $query->where('ready',1);

    //using paginate to auto divide resolts into groups of 20
    $results = $query->orderBy('last_check', 'desc')->paginate(20);
    $jeffcodes = Jeffcode::orderBy('jeffcode', 'asc')->get();
    return view('main.search', 
    [
        'results' => $results, 
        'input' => $request->all(), 
        'jeffcodes' => $jeffcodes,
    ]);
});

Route::get('/pay', function () {
    return view('main.pay');
});

Route::get('/slug', function () {
    $all = Contact::all();
    foreach($all as $con){
        $con->save();
    }        
    return view('main.pay');
});

Route::get('/contact/{slug}', function ($slug) {
    $contact = Contact::leftJoin('companies', 'companies.id', '=', 'contacts.company_id')
    ->leftJoin('jobs', 'jobs.id', '=', 'contacts.job_id')
    ->select('contacts.*', 'companies.main_company', 'companies.email_pattern', 'companies.sub_company as sub', 'jobs.job')
    ->where('slug',$slug)->first();
    if ($contact)
        return view('main.contact',['contact' => $contact]);
    else
        abort(404);
});

});

/* paths that deal with login info*/
Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'authenticate'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [LoginController::class, 'showRegistrationForm']);
Route::post('register', [LoginController::class, 'registrate'])->name('register');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth:customer')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth:customer', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:customer', 'throttle:6,1'])->name('verification.send');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink(
        $request->only('email')
    );
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) use ($request) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status == Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');