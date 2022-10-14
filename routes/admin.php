<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Contact;
use App\Models\Jeffcode;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Job;
use App\Models\Office;
use App\Http\Controllers\AdminLoginController;


//Authentication for employees 
Route::group(['domain' => 'employee.jeffscontacts.com'], function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm']);
    Route::post('login', [AdminLoginController::class, 'authenticate'])->name('login');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
});


//the employee must be authenicated in order to access ADMIN. This command will verify that the employee has privileges to use ADMiN. 
//employee.jeffscontacts.test
Route::group(['domain' => 'employee.jeffscontacts.com', 'middleware' => ['auth:employee']], function () {   

Route::get('/', function () {
    return view('employee.home');
});

//editing companies
Route::group(['prefix' => 'company',], function () {

    //get subcompanies
    Route::get('/getsub', function (Request $request) {
        $main_company = $request['main_company'];
        $subcompanies = Company::select('sub_company')
        ->where('main_company',$main_company)
        ->whereNotNull('sub_company')
        ->get();
        return response()->json($subcompanies);
    });
    
    //get company data
    Route::get('/getcomdata', function (Request $request) {
        $comapny = Company::with('jeffcodes')->with('offices')
        ->where('main_company',$request['main_company'])
        ->where('sub_company',$request['sub_company'])
        ->get();
        return response()->json($comapny);
    });

    //display companies
    Route::get('/', function (Request $request) {
        //get all companies
        $query = Company::query();
        if($value = $request->input('company_name')){
            $query = $query->where('companies.main_company','like', '%'.$value.'%')
            ->orWhere('companies.sub_company','like', '%'.$value.'%');
        }
        $companies = $query->orderBy('main_company', 'asc')->orderBy('sub_company', 'asc')->paginate(20);
        $jeffcodes = Jeffcode::orderBy('jeffcode', 'asc')->get();
        return view('employee.companies',
        [
            'companies' => $companies, 
            'input' => $request->all(), 
            'jeffcodes' => $jeffcodes
        ]);
    });

    //add company
    Route::post('/add', function (Request $request) {
        //validate input
        Validator::make($request->all(), [
            'main_company' => [
                'required'],
            'sub_company' => [
                'nullable',
                Rule::unique(Company::class)],
        ])->validate();
        //update record in db  
        $company = Company::create([
            'main_company' => request('main_company'),
            'sub_company' => request('sub_company'),
            'email_pattern' => request('email_pattern'),
        ]); 
        $company->jeffcodes()->sync(request('jeffcodes'));
        if(request('offices'))
            $company->offices()->createMany(request('offices'));
        return response('all good', 200)->header('Content-Type', 'text/plain');
    });

    //edit companies 
    Route::post('/{id}', function ($id,Request $request) {
        //validate input
        Validator::make($request->all(), [
            'main_company' => [
                'required'],
            'sub_company' => [
                'nullable',
                Rule::unique(Company::class)->ignore($id)],
        ])->validate();
        //update record in db  
        $company = Company::find($id);
        $company->main_company = $request->input('main_company');
        $company->sub_company = $request->input('sub_company');
        $company->email_pattern = $request->input('email_pattern');
        $company->jeffcodes()->sync(request('jeffcodes'));
        $company->offices()->delete();
        if(request('offices'))
            $company->offices()->createMany(request('offices'));
        $company->save();
        return response($id, 200)->header('Content-Type', 'text/plain');
    });

    //removing company from db
    Route::get('/remove/{id}', function ($id) {
        Company::where('id', $id)
        ->delete();
        return redirect('company');
    });
});

//editing jeffcodes
Route::group(['prefix' => 'jeffcode',], function () {


    //display jeffcodes
    Route::get('/', function (Request $request) {
        $query = Jeffcode::query();
        if($value = $request->input('jeffcode_search')){
            $query = $query->where('jeffcode','like', '%'.$value.'%');
        }
        $jeffcodes = $query->orderBy('jeffcode', 'asc')->paginate(20);
        return view('employee.jeffcodes',
        [
            'jeffcodes' => $jeffcodes, 
            'input' => $request->all(), 
        ]);
    });

    //add jeffcode
    Route::get('/add', function (Request $request) {
        //validate input
        Validator::make($request->all(), [
            'jeffcode' => [
                'required',
                'max:5',
                Rule::unique(Jeffcode::class)],
        ])->validate();
        //update record in db  
        Jeffcode::create([
            'jeffcode' => $request->input('jeffcode'),
        ]);
        return Redirect::back();
    });

    //edit jeffcode 
    Route::get('/{id}', function ($id,Request $request) {
        //validate input
        Validator::make($request->all(), [
            'jeffcode' => [
                'required',
                'max:5',
                Rule::unique(Jeffcode::class)->ignore($id),],
        ])->validate();
        //update record in db  
        $jeffcode = Jeffcode::find($id);
        $jeffcode->jeffcode = $request->input('jeffcode');
        $jeffcode->save();
        return Redirect::back();
    });

    //removing jeffcode
    Route::get('/remove/{id}', function ($id) {
        Jeffcode::where('id', $id)
        ->delete();
        return redirect('jeffcode');
    });
});

//editing job titles
Route::group(['prefix' => 'job_title',], function () {
    //display jobs
    Route::get('/', function (Request $request) {
        $query = Job::query();
        if($value = $request->input('job_search')){
            $query = $query->where('job','like', '%'.$value.'%');
        }
        $jobs = $query->orderBy('job', 'asc')->paginate(20);
        return view('employee.jobs',
        [
            'jobs' => $jobs, 
            'input' => $request->all(), 
        ]);
    });

    //add job
    Route::get('/add', function (Request $request) {
        //validate input
        Validator::make($request->all(), [
            'job' => [
                'required',
                Rule::unique(Job::class)],
        ])->validate();
        //update record in db  
        Job::create([
            'job' => $request->input('job'),
        ]);
        return Redirect::back();
    });

    //edit job 
    Route::get('/{id}', function ($id,Request $request) {
        //validate input
        Validator::make($request->all(), [
            'job' => [
                'required',
                Rule::unique(Job::class)->ignore($id),],
        ])->validate();
        //update record in db  
        $job = Job::find($id);
        $job->job = $request->input('job');
        $job->save();
        return Redirect::back();
    });

    //removing company
    Route::get('/remove/{id}', function ($id) {
        Job::where('id', $id)
        ->delete();
        return redirect('job_title');
    });
});

//editing contacts
Route::group(['prefix' => 'database'], function () {

    //get phone pattern for selected country
    Route::get('/phone_pattern/{country}', function ($country) {    
        $xml = Storage::disk('local')->get('phone_pattern.xml');
        $counries = new SimpleXMLElement($xml);
        $country = str_replace(' ', '', $country);
        $land = $counries->{$country}->land;
        $mobile = $counries->{$country}->mobile;
        if ($land == null || $mobile == null)
            abort(404);
        return response()->json([
            'land' => $land, 
            'mobile' => $mobile,
        ]);
    });

    //contact information page 
    Route::get('/', function () {
        session()->forget('list');
        //will show last record
        if($maxid = Contact::max('id'))
            return redirect('database/'.$maxid);
        //if no records will show add page
        else
            return redirect('database/add');
    });

    //show credit contact page used for adding contact record
    Route::get('/add', function () {
        //get all jeffcodes
        $jeffcodes = Jeffcode::orderBy('jeffcode', 'asc')->get();
        //get all companies
        $companies = Company::select('main_company')->orderBy('main_company', 'asc')->distinct()->get();
        //get all jobs
        $jobs = Job::orderBy('job', 'asc')->get();
        return view('employee.edit',
        [
            'jeffcodes' => $jeffcodes, 
            'companies' => $companies,
            'jobs' => $jobs,
        ]);
    });

    //show contact information page with data from contacts table for indicated record with given id
    Route::get('/{id}', function ($id) {
        $contact = Contact::leftJoin('companies', 'companies.id', '=', 'contacts.company_id')
        ->leftJoin('jobs', 'jobs.id', '=', 'contacts.job_id')
        ->select('contacts.*', 'companies.main_company','companies.email_pattern', 'companies.sub_company as sub', 'jobs.job as new_job')
        ->findOrFail($id);
        //get all jeffcodes
        $jeffcodes = Jeffcode::orderBy('jeffcode', 'asc')->get();
        //get all companies
        $companies = Company::select('main_company')->orderBy('main_company', 'asc')->distinct()->get();
        //get all jobs
        $jobs = Job::orderBy('job', 'asc')->get();
        //get employee who made last edit to contact
        $who_edited = Employee::find($contact->who_edited);
        //if record has employee then send his first and last name
        if(isset($who_edited))
            $employee_name = $who_edited->first_name." ".$who_edited->last_name;
        else
            $employee_name = null;
            
        //if contact has main company get all subcompanies
        $subcompanies = null;
        if(isset($contact->main_company)){
            $subcompanies = Company::select('sub_company')->where('main_company',$contact->main_company)->get();
        }
        //return $subcompanies;
        return view('employee.edit',
        [
            'contact' => $contact, 
            'jeffcodes' => $jeffcodes,
            'companies' => $companies, 
            'jobs' => $jobs,
            'who_edited' => $employee_name,
            'sub_companies' => $subcompanies,
        ]);
    });

    //show contacts page for previous record(using the less than sign)
    Route::get('/{id}/previous', function ($id) {    
        //if current record is first we go to the last record
        $minid = Contact::min('id');
        if ($minid == $id){
            $maxid = Contact::max('id');
            return redirect('database/'.$maxid);
        }
        //if current record is not first we get biggest id that is smaller then current
        $id = Contact::where('id', '<', $id)->max('id');
        return redirect('database/'.($id));
    });

    //show contacts page for next record(using the greater than sign)
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
                'email',
                Rule::unique(Contact::class),],
            'personal_email' => [
                'nullable', 
                'email',
                Rule::unique(Contact::class),],
            'mobile_phone_a' => [
                'nullable',
                'regex:/^[0-9 +-]+$/',
                Rule::unique(Contact::class),],
            'mobile_phone_b' => [
                'nullable',
                'regex:/^[0-9 +-]+$/',
                Rule::unique(Contact::class),],
            'direct_phone' => [
                'nullable',
                'regex:/^[0-9 +-]+$/',
                Rule::unique(Contact::class),],
            'li' => [
                'nullable',
                Rule::unique(Contact::class),],
        ])->validate();
        
        //prepare to save in db
        $ready = false;
        if ($request->input('ready'))
            $ready = true;
        $buyer = false;
        if ($request->input('buyer'))
            $buyer = true;
        $optedout = false;
        if ($request->input('optedout'))
            $optedout = true;
        //adding  contact to table
        $id = DB::table('contacts')->insertGetId(
        [
            'first_name' => $request->input('first_name'), 
            'last_name' => $request->input('last_name'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'office_phone' => $request->input('office_phone'),
            'direct_phone' => $request->input('direct_phone'),
            'mobile_phone_a' => $request->input('mobile_phone_a'),
            'mobile_phone_b' => $request->input('mobile_phone_b'),
            'work_email' => $request->input('work_email'),
            'personal_email' => $request->input('personal_email'),
            'li' => $request->input('li'),
            'ready' => $ready,
            'buyer' => $buyer,
            'optedout' => $optedout,
            'cost' => $request->input('cost'),
            'last_check' => now(),
            'notes' => $request ->input('notes'),
            'who_edited' => Auth::user()->id,
        ]);
        
        //check if job is set
        if ($value = $request->input('job')){
            $job = Job::select('id')->where('job', $value)->first();
            //if company does not exist in db create it
            if($job == null){
                $job_id = Job::insertGetId([
                    'job' => $value,
                ]);
            }
            else
            $job_id = $job->id;
            Contact::where('id', $id)->update(['job_id' => $job_id]);
        }

        //check if main company is set
        if ($request->input('main_company')){
            //if company does not exist in db create it
            $main_company = Company::select('id')->where('main_company', $request->input('main_company'))->count();
            if($main_company == 0){
                $company_id = Company::insertGetId([
                    'main_company' => $request->input('main_company'),
                    'sub_company' => $request->input('company'),
                ]);
            }
            else{
                //if sub company does not exist in db create it
                $sub_company = Company::select('id')
                ->where('main_company', $request->input('main_company'))
                ->where('sub_company', $request->input('company'))->first();
                if($sub_company == null){
                    $company_id = Company::insertGetId([
                        'main_company' => $request->input('main_company'),
                        'sub_company' => $request->input('company'),
                    ]);
                }
                else
                $company_id = $sub_company->id;
            }
            Contact::where('id', $id)->update(['company_id' => $company_id]);
        }

        //checck if photo is set and is valid(was loaded correctly)
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            
            //set photo name
            $image_name = "$id";
            $extension = $request->file('photo')->extension();
            $image_full_name = $image_name.".".$extension;
            //upload photo
            $request->file('photo')->storeAs('/public', $image_full_name);
            Contact::where('id', $id)->update(['photo' => $image_full_name]);
        }

        //conecting contact to jeffcodes
        $contact = Contact::find($id);
        $contact->jeffcodes()->sync(request('jeffcodes')); 
        
        if (session()->exists('list')){
            session()->push('list', ['id'=>$id]);
        }
                $contact->save();
        $contact->save();
        return redirect('database/'.$id);
    });

    //saving contact record changes to db
    Route::post('/{id}', function ($id,Request $request) {

        //validate input
        Validator::make($request->all(), [
            'work_email' => [
                'nullable', 
                'email',
                Rule::unique(Contact::class)->ignore($id),],
            'personal_email' => [
                'nullable',
                'email',
                Rule::unique(Contact::class)->ignore($id),],
            'mobile_phone_a' => [
                'nullable',
                'regex:/^[0-9 +-]+$/',
                Rule::unique(Contact::class)->ignore($id),],
            'mobile_phone_b' => [
                'nullable',
                'regex:/^[0-9 +-]+$/',
                Rule::unique(Contact::class)->ignore($id),],
            'direct_phone' => [
                'nullable',
                'regex:/^[0-9 +-]+$/',
                Rule::unique(Contact::class)->ignore($id),],
            'li' => [
                'nullable',
                Rule::unique(Contact::class)->ignore($id),],
        ])->validate();

        //prepare to save in db
        $ready = false;
        if ($request->input('ready'))
            $ready = true;
        $buyer = false;
        if ($request->input('buyer'))
            $buyer = true;
        $optedout = false;
        if ($request->input('optedout'))
            $optedout = true;
        //update record in db  
        Contact::where('id', $id)->update(
        [
            'first_name' => $request->input('first_name'), 
            'last_name' => $request->input('last_name'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'office_phone' => $request->input('office_phone'),
            'direct_phone' => $request->input('direct_phone'),
            'mobile_phone_a' => $request->input('mobile_phone_a'),
            'mobile_phone_b' => $request->input('mobile_phone_b'),
            'work_email' => $request->input('work_email'),
            'personal_email' => $request->input('personal_email'),
            'li' => $request->input('li'),
            'ready' => $ready,
            'buyer' => $buyer,
            'optedout' => $optedout,
            'cost' => $request->input('cost'),
            'last_check' => now(),
            'notes' => $request ->input('notes'),
            'who_edited' => Auth::user()->id,
        ]);
        
        //check if job is set
        if ($value = $request->input('job')){
            $job = Job::select('id')->where('job', $value)->first();
            //if company does not exist in db create it
            if($job == null){
                $job_id = Job::insertGetId([
                    'job' => $value,
                ]);
            }
            else
            $job_id = $job->id;
            Contact::where('id', $id)->update(['job_id' => $job_id, 'job' => NULL]);
        }else{
            Contact::where('id', $id)->update(['job_id' => NULL, 'job' => NULL]);            
        }
            
        //check if main company is set
        if ($request->input('main_company')){
            //if company does not exist in db create it
            $main_company = Company::select('id')->where('main_company', $request->input('main_company'))->count();
            if($main_company == 0){
                $company_id = Company::insertGetId([
                    'main_company' => $request->input('main_company'),
                    'sub_company' => $request->input('company'),
                ]);
            }
            else{
                //if sub company does not exist in db create it
                $sub_company = Company::select('id')
                ->where('main_company', $request->input('main_company'))
                ->where('sub_company', $request->input('company'))->first();
                if($sub_company == null){
                    $company_id = Company::insertGetId([
                        'main_company' => $request->input('main_company'),
                        'sub_company' => $request->input('company'),
                    ]);
                }
                else
                $company_id = $sub_company->id;
            }

            Contact::where('id', $id)->update(['company_id' => $company_id, 'company' => NULL, 'sub_company' => NULL]);
        }else{
            Contact::where('id', $id)->update(['company_id' => NULL, 'company' => NULL, 'sub_company' => NULL]);
        }

        //checck if photo is set and is valid(was loaded correctly)
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            
            //set photo name
            $image_name = "$id";
            $extension = $request->file('photo')->extension();
            $image_full_name = $image_name.".".$extension;
            //upload photo
            $request->file('photo')->storeAs('/public', $image_full_name);
            Contact::where('id', $id)->update(['photo' => $image_full_name]);
        }

        //conecting contact to jeffcodes
        $contact = Contact::find($id);
        $contact->jeffcodes()->sync(request('jeffcodes'));  
        //updating slug
        $contact->slug = null;
        $contact->save();
        return redirect('database/'.$id);
    });

    //removing contact record from db
    Route::get('/remove/{id}', function ($id) {
        $previous = null;
        if (session()->exists('list')) {
            $list = session()->pull('list');
            session(['list' => []]);
            for ($i = 0; $i < count($list);$i++){
                if($id != $list[$i]['id']){
                    session()->push('list', $list[$i]);
                }else{
                    if(count($list)>1){
                        if($i == 0){
                            $previous = $list[count($list)-1]['id'];
                        }else{
                            $previous = $list[$i-1]['id'];
                        }
                    }
                }
            }
        }
        Contact::where('id', $id)
        ->delete();
        if($previous)
            return redirect('database/'.$previous);
        return redirect('database/'.($id).'/previous');
    });
});

//search 
Route::group(['prefix' => 'search',], function () {
    
    //show search page with results
    Route::get('/', function (Request $request) {

        $query = Contact::query()
        ->leftJoin('companies', 'companies.id', '=', 'contacts.company_id')->leftJoin('jobs', 'jobs.id', '=', 'contacts.job_id');

        //selecting what data we need to send
        $query = $query->select([
            'contacts.id',
            'contacts.first_name',
            'contacts.last_name',
            'contacts.work_email',
            'contacts.personal_email',
            'contacts.last_check',
            'contacts.company as old_main',
            'contacts.sub_company as old_company',
            'companies.main_company as main_company',
            'companies.sub_company as sub_company']);
        
        //setting search parametrs
        if($value = $request->input('first_name')){
            if (strtolower($value)  == 'null')
                $query = $query->whereNull('first_name');
            else
                $query = $query->where('first_name','like', '%'.$value.'%');
        }
        if($value = $request->input('last_name')){
            if (strtolower($value)  == 'null')
                $query = $query->whereNull('last_name');
            else
                $query = $query->where('last_name','like', '%'.$value.'%');
        }
        if($value = $request->input('email')){
            if (strtolower($value)  == 'null')
                $query = $query->where(function ($query) use ($value) {
                    $query = $query->whereNull('work_email')
                    ->WhereNull('personal_email');
                });
            else
                $query = $query->where(function ($query) use ($value) {
                    $query = $query->where('work_email','like', '%'.$value.'%')
                    ->orWhere('personal_email','like', '%'.$value.'%');
                });
        }
        if($value = $request->input('job')){
            if (strtolower($value)  == 'null')
                $query = $query->whereNull('contacts.job_id');
            else
                $query = $query->where(function ($query) use ($value) {
                    $query = $query->where('jobs.job','like', '%'.$value.'%')
                    ->orWhere('contacts.job','like', '%'.$value.'%');
                });
        }
        if($value = $request->input('company')){
            if (strtolower($value)  == 'null')
                $query = $query->whereNull('contacts.company_id');
            else
                $query = $query->where(function ($query) use ($value) {
                    $query = $query->where('companies.main_company','like', '%'.$value.'%')
                    ->orWhere('companies.sub_company','like', '%'.$value.'%')
                    ->orWhere('contacts.company','like', '%'.$value.'%')
                    ->orWhere('contacts.sub_company','like', '%'.$value.'%');
                });
        }
        if($value = $request->input('jeffcodes')){
            foreach($value as $code)
                $query = $query->whereIn('contacts.id', DB::table('contact_jeffcode')->select('contact_id')->where('jeffcode_id',$code));
        }
        if($value = $request->input('id_from'))
            $query = $query->where('contacts.id','>=', $value);
        if($value = $request->input('id_to'))
            $query = $query->where('contacts.id','<=', $value);
        
        if($value = $request->input('ready'))
            if ($value == 1)
                $query = $query->where('ready',false);
            else
                $query = $query->where('ready',true);

        if($value = $request->input('order'))
            $query = $query->orderBy('last_check', 'asc');
        else
            $query = $query->orderBy('last_check', 'desc');
        //using paginate to auto divide resolts into groups of 20
        $results = $query->paginate(20);
        $jeffcodes = Jeffcode::orderBy('jeffcode', 'asc')->get();
        $jobs = Job::all();
        return view('employee.search', ['results' => $results, 'input' => $request->all(), 'jeffcodes' => $jeffcodes, 'jobs' => $jobs]);
    });
    
    //get list of all  contacts with matching names
    Route::get('/verify', function (Request $request) {
        $query = Contact::query()
        ->leftJoin('companies', 'companies.id', '=', 'contacts.company_id');

        //selecting what data we need to send
        $query = $query->select([
            'contacts.first_name',
            'contacts.last_name',
            'contacts.company',
            'contacts.sub_company',
            'companies.main_company',
            'companies.sub_company as sub']);
        
        //setting search parametrs
        if($value = $request->input('first_name'))
            $query = $query->where('first_name','like', '%'.$value.'%');
        if($value = $request->input('last_name'))
            $query = $query->where('last_name','like', '%'.$value.'%');
        return $query->get();
    });
    
    //show empty contacts(contacts with no first and last names)
    Route::get('/null_names', function (Request $request) {
        $query = Contact::query()
        ->leftJoin('companies', 'companies.id', '=', 'contacts.company_id');

        //selecting what data we need to send
        $query = $query->select([
            'contacts.id',
            'contacts.first_name',
            'contacts.last_name',
            'contacts.work_email',
            'contacts.personal_email',
            'contacts.last_check',
            'companies.main_company']);
            

        $query = $query->orderBy('last_check', 'desc');
            
        $results = $query->whereNull('first_name')->whereNull('last_name')->paginate(20);
        $jeffcodes = Jeffcode::orderBy('jeffcode', 'asc')->get();
        return view('employee.search', ['results' => $results, 'input' => $request->all(), 'jeffcodes' => $jeffcodes]);
    });
    
    //show search duplicate names not implemented
    Route::get('/dupnames', function (Request $request) {
        abort(404);
        return "not implemented";//view('employee.search', ['results' => []]);
    });
    
    //set search output to session list so that move buttons on contact edit page will move over them 
    Route::get('/list/{id}', function ($id,Request $request) {
        $query = Contact::query()
        ->leftJoin('companies', 'companies.id', '=', 'contacts.company_id')
        ->leftJoin('jobs', 'jobs.id', '=', 'contacts.job_id');

        //selecting what data we need to send
        $query = $query->select([
            'contacts.id']);
        
        //setting search parametrs
        if($value = $request->input('first_name')){
            if (strtolower($value)  == 'null')
                $query = $query->whereNull('first_name');
            else
                $query = $query->where('first_name','like', '%'.$value.'%');
        }
        if($value = $request->input('last_name')){
            if (strtolower($value)  == 'null')
                $query = $query->whereNull('last_name');
            else
                $query = $query->where('last_name','like', '%'.$value.'%');
        }
        if($value = $request->input('email')){
            if (strtolower($value)  == 'null')
                $query = $query->where(function ($query) use ($value) {
                    $query = $query->whereNull('work_email')
                    ->WhereNull('personal_email');
                });
            else
                $query = $query->where(function ($query) use ($value) {
                    $query = $query->where('work_email','like', '%'.$value.'%')
                    ->orWhere('personal_email','like', '%'.$value.'%');
                });
        }
        if($value = $request->input('job')){
            if (strtolower($value)  == 'null')
                $query = $query->whereNull('contacts.job_id');
            else
                $query = $query->where(function ($query) use ($value) {
                    $query = $query->where('jobs.job','like', '%'.$value.'%')
                    ->orWhere('contacts.job','like', '%'.$value.'%');
                });
        }
        if($value = $request->input('company')){
            if (strtolower($value)  == 'null')
                $query = $query->whereNull('contacts.company_id');
            else
                $query = $query->where(function ($query) use ($value) {
                    $query = $query->where('companies.main_company','like', '%'.$value.'%')
                    ->orWhere('companies.sub_company','like', '%'.$value.'%')
                    ->orWhere('contacts.company','like', '%'.$value.'%')
                    ->orWhere('contacts.sub_company','like', '%'.$value.'%');
                });
        }
        if($value = $request->input('jeffcodes')){
            foreach($value as $code)
                $query = $query->whereIn('contacts.id', DB::table('contact_jeffcode')->select('contact_id')->where('jeffcode_id',$code));
        }
        if($value = $request->input('id_from'))
            $query = $query->where('contacts.id','>=', $value);
        if($value = $request->input('id_to'))
            $query = $query->where('contacts.id','<=', $value);
        
        if($value = $request->input('ready'))
            if ($value == 1)
                $query = $query->where('ready',false);
            else
                $query = $query->where('ready',true);

        if($value = $request->input('order'))
            $query = $query->orderBy('last_check', 'asc');
        else
            $query = $query->orderBy('last_check', 'desc');
        $list = $query->get()->toArray();
        session(['list' => $list]);
        return redirect('database/'.($id));
    });

});

//editing employees
Route::group(['prefix' => 'employees',], function () {
    
    //show all employees
    Route::get('/', function () {
        //selecting only what we need
        $employees = Employee::all();
        return view('employee.employees', ['employees' => $employees]);
    });

    //show edit page for adding employee
    Route::get('/add', function () {
        return view('employee.employee_edit');
    });

    //show edit page for record with given id
    Route::get('/{id}', function ($id) {
        $employee = Employee::findOrFail($id);
        return view('employee.employee_edit',['employee' => $employee]);
    });

    //adding contact employee to db
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
                    Rule::unique(Employee::class),
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
                $create = true;        
            $remove = false;
            if($request['remove'])
                $remove = true;
        }

        Employee::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'admin' => $admin,
            'edit' => $edit,
            'create' => $create,
            'remove' => $remove,
            'password' => Hash::make($request['password']),
        ]);
        return redirect('employees/');
    });

    //saving employee changes to db
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
                    Rule::unique(Employee::class)->ignore($id),
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
        Employee::where('id', $id)
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
            Employee::where('id', $id)
            ->update(
                ['password' => Hash::make($request['password'])]
            );

        return redirect('employees/');
    });

    //removing employee from db
    Route::get('/remove/{id}', function ($id) {
        Employee::where('id', $id)
        ->delete();
        return redirect('employees/');
    });

});

});