<?php

namespace App\Http\Controllers;

use App\Models\ContactPerson;
use App\Http\Requests\StoreContactPersonRequest;
use App\Http\Requests\UpdateContactPersonRequest;

class ContactPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactPersonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactPerson $contactPerson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactPerson $contactPerson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactPersonRequest $request, ContactPerson $contactPerson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactPerson $contactPerson)
    {
        //
    }
}
