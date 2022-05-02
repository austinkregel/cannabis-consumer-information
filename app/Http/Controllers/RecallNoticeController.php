<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecallNoticeRequest;
use App\Http\Requests\UpdateRecallNoticeRequest;
use App\Models\RecallNotice;

class RecallNoticeController extends Controller
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
     * @param  \App\Http\Requests\StoreRecallNoticeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecallNoticeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecallNotice  $recallNotice
     * @return \Illuminate\Http\Response
     */
    public function show(RecallNotice $recallNotice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RecallNotice  $recallNotice
     * @return \Illuminate\Http\Response
     */
    public function edit(RecallNotice $recallNotice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecallNoticeRequest  $request
     * @param  \App\Models\RecallNotice  $recallNotice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecallNoticeRequest $request, RecallNotice $recallNotice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecallNotice  $recallNotice
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecallNotice $recallNotice)
    {
        //
    }
}
