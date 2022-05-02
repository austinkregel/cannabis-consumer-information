<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrowerRequest;
use App\Http\Requests\UpdateGrowerRequest;
use App\Models\Grower;

class GrowerController extends Controller
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
     * @param  \App\Http\Requests\StoreGrowerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrowerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grower  $grower
     * @return \Illuminate\Http\Response
     */
    public function show(Grower $grower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grower  $grower
     * @return \Illuminate\Http\Response
     */
    public function edit(Grower $grower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGrowerRequest  $request
     * @param  \App\Models\Grower  $grower
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGrowerRequest $request, Grower $grower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grower  $grower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grower $grower)
    {
        //
    }
}
