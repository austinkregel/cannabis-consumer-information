<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecallRequest;
use App\Http\Requests\UpdateRecallRequest;
use App\Models\Recall;

class RecallController extends Controller
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
     * @param  \App\Http\Requests\StoreRecallRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecallRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recall  $recall
     * @return \Illuminate\Http\Response
     */
    public function show(Recall $recall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recall  $recall
     * @return \Illuminate\Http\Response
     */
    public function edit(Recall $recall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecallRequest  $request
     * @param  \App\Models\Recall  $recall
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecallRequest $request, Recall $recall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recall  $recall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recall $recall)
    {
        //
    }
}
