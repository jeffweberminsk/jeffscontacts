<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/db', function () {
    return view('db');
})->middleware(['auth']);

//show home page
Route::get('/', function () {
    return view('home');
})->middleware(['auth']);

//editing contacts 
Route::group(['prefix' => 'database','middleware' => ['auth']], function () {

    //main page 
    Route::get('/', function () {
        //will show last record
        if($maxid = DB::table('contacts')->max('id'))
            return redirect('database/'.$maxid);
        //if no records will show add page
        else
            return redirect('database/add');
    });

    //show edit page for adding contact record
    Route::get('/add', function () {
        return view('edit');
    });

    //show edit page for record with given id
    Route::get('/{id}', function ($id) {
        $contact = Contact::findOrFail($id);
        return view('edit',['contact' => $contact]);
    });

    //show edit page for previous record(orderd by id)
    Route::get('/{id}/previous', function ($id) {    
        //if current record is first we go to the last record
        $minid = DB::table('contacts')->min('id');
        if ($minid == $id){
            $maxid = DB::table('contacts')->max('id');
            return redirect('database/'.$maxid);
        }
        //if current record is not first we  get biggest id that is smaller then current
        $id = DB::table('contacts')->where('id', '<', $id)->max('id');
        return redirect('database/'.($id));
    });

    //show edit page for next record(orderd by id)
    Route::get('/{id}/next', function ($id) {
        //if current record is last we go to the first record
        $maxid = DB::table('contacts')->max('id');
        if ($maxid == $id){
            $minid = DB::table('contacts')->min('id');
            return redirect('database/'.$minid);
        }
        //if current record is not first we  get smalles id that is bigger then current
        $id = DB::table('contacts')->where('id', '>', $id)->min('id');
        return redirect('database/'.($id));
    });

    //adding contact record to db
    Route::post('/add', function (Request $request) {

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
        $ready = false;
        if ($request ->input('ready'))
            $ready = true;

        $buyer = false;
        if ($request ->input('buyer'))
            $buyer = true;
        DB::table('contacts')
                ->where('id', $id)
                ->update(
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

    //removing contact record from db
    Route::get('/remove/{id}', function ($id) {
        DB::table('contacts')
        ->where('id', $id)
        ->delete();
        return redirect('database/'.($id).'/previous');
    });

    //duplicating contact record NOT IMPLEMENTED
    Route::get('/dup/{id}', function ($id) {
        $contact = Contact::findOrFail($id);
        return view('edit',['contact' => $contact]);
    });
});

//search 
Route::group(['prefix' => 'search','middleware' => ['auth']], function () {
    
    //show search page without results
    Route::get('/', function () {
        return view('search');
    });

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
        return view('search', ['results' => $results]);
    });

    //show search duplicate names
    Route::get('/dupnames', function (Request $request) {

        return view('search', ['results' => []]);
    });

});

//editing users
Route::group(['prefix' => 'users','middleware' => ['auth']], function () {
    
    //show search page without search result
    Route::get('/', function () {
        $users = User::all();//select(['id','first_name','last_name','email','admin']);
        return view('users', ['users' => $users]);
    });

});