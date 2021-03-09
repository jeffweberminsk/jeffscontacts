<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Contact;
use App\Models\User;

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


//the user must be authenicated in order to access ADMIN. This command will verify that the user has privileges to use ADMiN. 
Route::group(['domain' => 'employee.jeffscontacts.test', 'middleware' => ['auth', 'employee']], function () {
    
Route::get('/', function () {
    return view('employee.home');
});

//editing contacts
Route::group(['prefix' => 'database'], function () {

    //main page 
    Route::get('/', function () {
        //will show last record
        if($maxid = Contact::max('id'))
            return redirect('database/'.$maxid);
        //if no records will show add page
        else
            return redirect('database/add');
    });

    //show edit page for adding contact record
    Route::get('/add', function () {
        return view('employee.edit');
    });

    //show edit page for record with given id
    Route::get('/{id}', function ($id) {
        $contact = Contact::findOrFail($id);
        return view('employee.edit',['contact' => $contact]);
    });

    //show edit page for previous record(orderd by id)
    Route::get('/{id}/previous', function ($id) {    
        //if current record is first we go to the last record
        $minid = Contact::min('id');
        if ($minid == $id){
            $maxid = Contact::max('id');
            return redirect('database/'.$maxid);
        }
        //if current record is not first we  get biggest id that is smaller then current
        $id = Contact::where('id', '<', $id)->max('id');
        return redirect('database/'.($id));
    });

    //show edit page for next record(orderd by id)
    Route::get('/{id}/next', function ($id) {
        //if current record is last we go to the first record
        $maxid = Contact::max('id');
        if ($maxid == $id){
            $minid = Contact::min('id');
            return redirect('database/'.$minid);
        }
        //if current record is not first we  get smalles id that is bigger then current
        $id = Contact::where('id', '>', $id)->min('id');
        return redirect('database/'.($id));
    });

    //adding contact record to db
    Route::post('/add', function (Request $request) {

        //validate input
        Validator::make($request->all(), [
            'work_email' => [
                'nullable', 
                Rule::unique(Contact::class),],
            'personal_email' => [
                'nullable', 
                Rule::unique(Contact::class),],
            'mobile_phone_a' => [
                'nullable',
                Rule::unique(Contact::class),],
            'mobile_phone_b' => [
                'nullable',
                Rule::unique(Contact::class),],
            'direct_phone' => [
                'nullable',
                Rule::unique(Contact::class),],
            'li' => [
                'nullable',
                Rule::unique(Contact::class),],
            ])->validate();

        //save in db
        $ready = false;
        if ($request->input('ready'))
            $ready = true;
        $buyer = false;
        if ($request->input('buyer'))
            $buyer = true;
        $id = DB::table('contacts')->insertGetId(
            ['first_name' => $request->input('first_name'), 
            'last_name' => $request ->input('last_name'),
            'job' => $request ->input('job'),
            'company' => $request ->input('company'),
            'city' => $request ->input('city'),
            'state' => $request ->input('state'),
            'country' => $request ->input('country'),
            'office_phone' => $request ->input('office_phone'),
            'direct_phone' => $request ->input('direct_phone'),
            'mobile_phone_a' => $request ->input('mobile_phone_a'),
            'mobile_phone_b' => $request ->input('mobile_phone_b'),
            'work_email' => $request ->input('work_email'),
            'personal_email' => $request ->input('personal_email'),
            'li' => $request ->input('li'),
            'jeffcode' => $request ->input('jeffcode'),
            'ready' => $ready,
            'buyer' => $buyer,
            'last_check' => now(),
            'notes' => $request ->input('notes')]
            );
        return redirect('database/'.$id);
    });

    //saving contact record changes to db
    Route::post('/{id}', function ($id,Request $request) {

        //validate input
        Validator::make($request->all(), [
            'work_email' => [
                'nullable', 
                Rule::unique(Contact::class)->ignore($id),],
            'personal_email' => [
                'nullable', 
                Rule::unique(Contact::class)->ignore($id),],
            'mobile_phone_a' => [
                'nullable',
                Rule::unique(Contact::class)->ignore($id),],
            'mobile_phone_b' => [
                'nullable',
                Rule::unique(Contact::class)->ignore($id),],
            'direct_phone' => [
                'nullable',
                Rule::unique(Contact::class)->ignore($id),],
            'li' => [
                'nullable',
                Rule::unique(Contact::class)->ignore($id),],
            ])->validate();

        $ready = false;
        if ($request ->input('ready'))
            $ready = true;

        $buyer = false;
        if ($request ->input('buyer'))
            $buyer = true;
        DB::table('contacts')->where('id', $id)
                ->update(
                    ['first_name' => $request->input('first_name'), 
                    'last_name' => $request ->input('last_name'),
                    'job' => $request ->input('job'),
                    'company' => $request ->input('company'),
                    'city' => $request ->input('city'),
                    'state' => $request->state,
                    'country' => $request ->input('country'),
                    'office_phone' => $request ->input('office_phone'),
                    'direct_phone' => $request ->input('direct_phone'),
                    'mobile_phone_a' => $request ->input('mobile_phone_a'),
                    'mobile_phone_b' => $request ->input('mobile_phone_b'),
                    'work_email' => $request ->input('work_email'),
                    'personal_email' => $request ->input('personal_email'),
                    'li' => $request ->input('li'),
                    'jeffcode' => $request ->input('jeffcode'),
                    'ready' => $ready,
                    'buyer' => $buyer,
                    'last_check' => now(),
                    'notes' => $request ->input('notes')]
                );
        return redirect('database/'.$id);
    });

    //removing contact record from db
    Route::get('/remove/{id}', function ($id) {
        Contact::where('id', $id)
        ->delete();
        return redirect('database/'.($id).'/previous');
    });
});

//search 
Route::group(['prefix' => 'search',], function () {
    
    //show search page with results
    Route::get('/', function (Request $request) {

        $query = Contact::query();
        //selecting what data we need to send
        $query = $query->select(['id','first_name','last_name','work_email','company','personal_email']);
        
        //setting search parametrs
        if($value = $request->input('first_name'))
            $query = $query->where('first_name','like', '%'.$value.'%');
        if($value = $request->input('last_name'))
            $query = $query->where('last_name','like', '%'.$value.'%');
        if($value = $request->input('company'))
            $query = $query->where('company','like', '%'.$value.'%');
        if($value = $request->input('email'))
            $query = $query->where('work_email','like', '%'.$value.'%')
                    ->orWhere('personal_email','like', '%'.$value.'%');
        
        if($value = $request->input('id_from'))
            $query = $query->where('id','>=', $value);
        if($value = $request->input('id_to'))
            $query = $query->where('id','<=', $value);
        
        if($value = $request->input('ready'))
            if ($value == 1)
                $query = $query->where('ready',false);
            else
                $query = $query->where('ready',true);
        //using paginate to auto divide resolts into groups of 20
        $results = $query->paginate(20);
        return view('employee.search', ['results' => $results]);
    });

    //show search duplicate names
    Route::get('/dupnames', function (Request $request) {
        abort(404);
        return "not implemented";//view('employee.search', ['results' => []]);
    });

});

//editing users
Route::group(['prefix' => 'users',], function () {
    
    //show all users
    Route::get('/', function () {
        //selecting only what we need
        $users = User::where('employee', 1)->select(['id','first_name','last_name','email','admin'])->get();
        return view('employee.users', ['users' => $users]);
    });

    //show edit page for adding user
    Route::get('/add', function () {
        return view('employee.useredit');
    });

    //show edit page for record with given id
    Route::get('/{id}', function ($id) {
        $user = User::findOrFail($id);
        return view('employee.useredit',['user' => $user]);
    });

    //adding contact user to db
    Route::post('/add', function (Request $request) {

        //validate input
        Validator::make($request->all(), [
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
                'password' => [
                    'required', 
                    'string',
                    'confirmed'
                ],
            ])->validate();

        //set all privileges if admin is set 
        $admin = false;
        if($request['admin']){
            $admin = true;
            $edit = true;
            $create = true;
            $remove = true; 
        }
        else{
            $edit = false;
            if($request['edit'])
                $edit = true;        
            $create = false;
            if($request['create'])
                $edit = true;        
            $remove = false;
            if($request['remove'])
                $remove = true;
        }

        User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'employee' => 1,
            'admin' => $admin,
            'edit' => $edit,
            'create' => $create,
            'remove' => $remove,
            'password' => Hash::make($request['password']),
        ]);
        return redirect('users/');
    });

    //saving user changes to db
    Route::post('/{id}', function ($id,Request $request) {
        //validate input
        Validator::make($request->all(), [
            'first_name' => [
                'required', 
                'string', 
                'max:255',
            ],
            'last_name' => [
                'required', 
                'string', 
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                    Rule::unique(User::class)->ignore($id),
                ],
            'password' => [
                'nullable', 
                'string',
                'confirmed'
            ],
        ])->validate();

        //set all privileges if admin is set
        $admin = false;
        if($request['admin']){
            $admin = true;
            $edit = true;
            $create = true;
            $remove = true; 
        }
        else{
            $edit = false;
            if($request['edit'])
                $edit = true;        
            $create = false;
            if($request['create'])
                $create = true;        
            $remove = false;
            if($request['remove'])
                $remove = true;
        }

        //updating all the fieledes accept password
        DB::table('users')
        ->where('id', $id)
        ->update(
            [
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'admin' => $admin,
                'edit' => $edit,
                'create' => $create,
                'remove' => $remove]
        );

        //updaing password field olny if new password was entered
        if ($request['password'])
            DB::table('users')
            ->where('id', $id)
            ->update(
                ['password' => Hash::make($request['password'])]
            );

        return redirect('users/');
    });

    //removing user from db
    Route::get('/remove/{id}', function ($id) {
        DB::table('users')
        ->where('id', $id)
        ->delete();
        return redirect('users/');
    });

});

});

//site routes accesible to regular users 

//show home page
Route::get('/', function () {
    return view('main.search');
});

Route::get('/plans', function () {
    return view('main.plans');
});

Route::get('/user', function () {
    return view('main.user');
});

Route::get('/search', function (Request $request) {
    $query = Contact::query();
    //selecting what data we need to send
    $query = $query->select(['id','first_name','last_name','work_email','company','personal_email', 'photo']);
    
    //setting search parametrs
    if($value = $request->input('job'))
        $query = $query->where('job','like', '%'.$value.'%');
    if($value = $request->input('company'))
        $query = $query->where('company','like', '%'.$value.'%');
    if($value = $request->input('city'))
        $query = $query->where('city','like', '%'.$value.'%');
    if($value = $request->input('country'))
        $query = $query->where('country','like', '%'.$value.'%');
    if($value = $request->input('jeffcode'))
        $query = $query->where('jeffcode','like', '%'.$value.'%');
    if($value = $request->input('name')){
        foreach(explode(" ", $value) as $word )            
            $query = $query->where(function ($query) use ($word) {
                $query->where('first_name','like', '%'.$word.'%')
                ->orWhere('last_name','like', '%'.$word.'%');  
            });  
    }

    //using paginate to auto divide resolts into groups of 20
    $results = $query->paginate(20);

    return view('main.search', ['results' => $results]);
});

Route::get('/contact', function () {
    return view('main.contact');
});

Route::get('/pay', function () {
    return view('main.pay');
});


