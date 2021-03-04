<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        return redirect('database/'.$id);
        $id = Contact::create(
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
            )->id;
        return redirect('database/'.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $contact = Contact::findOrFail($id);
        return view('edit',['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
