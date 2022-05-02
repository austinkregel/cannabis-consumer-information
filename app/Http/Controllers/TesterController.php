<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTesterRequest;
use App\Http\Requests\UpdateTesterRequest;
use App\Models\Tester;

class TesterController extends Controller
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
     * @param  \App\Http\Requests\StoreTesterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTesterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tester  $tester
     * @return \Illuminate\Http\Response
     */
    public function show(Tester $tester)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tester  $tester
     * @return \Illuminate\Http\Response
     */
    public function edit(Tester $tester)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTesterRequest  $request
     * @param  \App\Models\Tester  $tester
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTesterRequest $request, Tester $tester)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tester  $tester
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tester $tester)
    {
        //
    }
}
