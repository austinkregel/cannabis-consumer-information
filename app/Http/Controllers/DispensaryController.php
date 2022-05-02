<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDispensaryRequest;
use App\Http\Requests\UpdateDispensaryRequest;
use App\Models\Dispensary;

class DispensaryController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDispensaryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDispensaryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dispensary  $dispensary
     * @return \Illuminate\Http\Response
     */
    public function show(Dispensary $dispensary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dispensary  $dispensary
     * @return \Illuminate\Http\Response
     */
    public function edit(Dispensary $dispensary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDispensaryRequest  $request
     * @param  \App\Models\Dispensary  $dispensary
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDispensaryRequest $request, Dispensary $dispensary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dispensary  $dispensary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dispensary $dispensary)
    {
        //
    }
}
