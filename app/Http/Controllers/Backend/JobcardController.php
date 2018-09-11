<?php

namespace App\Http\Controllers\Backend;

use App\Models\Jobcard;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJobcardRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\JobcardRepository;

class JobcardController extends BackendController
{
    /**
     * @var JobcardRepository
     */
    protected $jobcards;

    /**
     * Create a new controller instance.
     *
     *
     * @param \App\Repositories\Contracts\JobcardRepository $jobcards
     */
    public function __construct(JobcardRepository $jobcard)
    {
        //dd($jobcards);
        $this->jobcard = $jobcard;
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
        $this->authorize('create jobcard');
        //dd($request->all());    
        $jobcard = $this->jobcard->make(
            $request->only('jobcard_num')
        ); 
        
        if ('publish' === $request->input('status')) {
            $this->jobcard->saveAndPublish($jobcard, $request->input());
        } else {
            $this->jobcard->saveAsDraft($jobcard, $request->input());
        }

        return $this->redirectResponse($request, __('alerts.backend.jobcards.created'));
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
