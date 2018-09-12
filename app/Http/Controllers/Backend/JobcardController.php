<?php

namespace App\Http\Controllers\Backend;

use App\Models\Jobcard;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreJobcardRequest;
use App\Http\Requests\UpdateJobcardRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\JobcardRepository;


class JobcardController extends BackendController
{
    /**
     * @var JobcardRepository
     */
    protected $jobcard;

    /**
     * Create a new controller instance.
     *
     *
     * @param \App\Repositories\Contracts\JobcardRepository $jobcard
     */
    public function __construct(JobcardRepository $jobcard)
    {
        //dd($jobcards);
        $this->jobcard = $jobcard;
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function search(Request $request)
    {

        /** @var Builder $query */
        $query = $this->jobcard->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'jobcard_num',
            'description',
            'problem_type',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'jobcard_num',
                'description',
                'problem_type',
                'priority',
                'jobcard.created_at',
                'jobcard.updated_at',
            ],
                [
                    __('validation.jobcards.jobcard_num'),
                    __('validation.jobcards.description'),
                    __('validation.jobcards.problem_type'),
                    __('validation.jobcards.priority'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'jobcard');
        }

        return $requestSearchQuery->result([
            'jobcard.id',
            'jobcard_num',
            'description',
            'problem_type',
            'priority',
            'status',
            'facility_name',
            'district',
            'sub_district',
            'quoted_amount',
            'before_pictures',
            'during_pictures',
            'after_pictures',
            'jobcard.created_at',
            'jobcard.updated_at',
        ]);
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
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getLastestJobcards()
    {
        $query = $this->jobcard->query();        

        return $query->orderByDesc('created_at')->limit(10)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function show(Jobcard $jobcard)
    {
        return $jobcard;
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
     * @param Jobcard              $jobcard
     * @param UpdateJobcardRequest $request
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     *
     * @return mixed
     */
    public function update(Jobcard $jobcard, UpdateJobcardRequest $request)
    {
        
        $jobcard->fill(
            $request->only('jobcard_num')
        );
        
        $this->jobcard->saveAndPublish($jobcard, $request->input());
           
        return $this->redirectResponse($request, __('alerts.backend.jobcards.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobcard $jobcard, Request $request)
    {
        $this->jobcard->destroy($jobcard);

        return $this->redirectResponse($request, __('alerts.backend.jobcards.deleted'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function batchAction(Request $request)
    {
        $action = $request->get('action');
        $ids = $request->get('ids');
        
        switch ($action) {
            case 'destroy':                
                    $this->jobcard->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.jobcards.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
