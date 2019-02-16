<?php

namespace App\Http\Controllers\Backend;

use App\Models\LabourRate;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreLabourRateRequest;
use App\Http\Requests\UpdateLabourRateRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\LabourRateRepository;

class LabourRateController extends BackendController
{
    /**
     * @var LabourRateRepository
     */
    protected $labour_rate;

    public function __construct(LabourRateRepository $labour_rate)
    {
        //dd($jobcards);
        $this->labour_rate = $labour_rate;
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
        $query = $this->labour_rate->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'name',
            'rate',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'name',
                'rate',
                'labour_rates.created_at',
                'labour_rates.updated_at',
            ],
                [
                    __('validation.labour_rates.name'),
                    __('validation.labour_rates.rate'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'labour_rates');
        }

        return $requestSearchQuery->result([
            'labour_rates.id',
            'name',
            'rate',
            'labour_rates.created_at',
            'labour_rates.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLabourRateRequest $request)
    {
        //dd($request->all());    
        $labour_rate = $this->labour_rate->make(
            $request->only('name','rate')
        ); 
        
       $this->labour_rate->save($labour_rate, $request->input());

       return $this->redirectResponse($request, __('alerts.backend.labour_rates.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LabourRate  $labour_rate
     * @return \Illuminate\Http\Response
     */
    public function show(LabourRate $labour_rate)
    {
       return $labour_rate;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LabourRate  $labour_rate
     * @return \Illuminate\Http\Response
     */
    public function edit(LabourRate $labour_rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LabourRate  $labour_rate
     * @return \Illuminate\Http\Response
     */
    public function update(LabourRate $labour_rate, UpdateLabourRateRequest $request)
    {
        $labour_rate->fill(
            $request->only('name','rate')
        );
        
        $this->labour_rate->save($labour_rate, $request->input());
           
        return $this->redirectResponse($request, __('alerts.backend.labour_rates.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LabourRate  $labour_rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(LabourRate $labour_rate, Request $request)
    {

        $this->labour_rate->destroy($labour_rate);

        return $this->redirectResponse($request, __('alerts.backend.labour_rates.deleted'));
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
                    $this->labour_rate->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.labour_rates.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
