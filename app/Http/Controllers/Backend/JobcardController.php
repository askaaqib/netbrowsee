<?php

namespace App\Http\Controllers\Backend;

use App\Models\Jobcard;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJobcardRequest;


class JobcardController extends Controller
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
     * @param StoreJobcardRequest $request
     *
     * @return mixed
     */
    public function store(StoreJobcardRequest $request)
    {
        $this->authorize('create jobcards');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function show(Jobcard $jobcard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobcard $jobcard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jobcard $jobcard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobcard $jobcard)
    {
        //
    }
}
