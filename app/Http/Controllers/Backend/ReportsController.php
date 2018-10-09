<?php

namespace App\Http\Controllers\Backend;

use App\Models\Reports;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreReportsRequest;
use App\Http\Requests\UpdateReportsRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\ReportsRepository;

class ReportsController extends BackendController
{
    /**
     * @var ReportsRepository
     */
    protected $report;

    public function __construct(ReportsRepository $reports)
    {
        //dd($jobcards);
        $this->report = $reports;
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
        $query = $this->report->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'description',
            'status',
            'expenses',
            'amount',
            'vat_collected',
            'profit_loss',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([                
                'description',
                'status',
                'expenses',
                'amount',
                'vat_collected',
                'profit_loss',
                'reports.created_at',
                'reports.updated_at',
            ],
                [
                    __('validation.reports.description'),
                    __('validation.reports.status'),
                    __('validation.reports.expenses'),
                    __('validation.reports.amount'),
                    __('validation.reports.vat_collected'),
                    __('validation.reports.profit_loss'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'reports');
        }

        return $requestSearchQuery->result([
            'id',
            'description',
            'status',
            'expenses',
            'amount',
            'vat_collected',
            'profit_loss',
            'reports.created_at',
            'reports.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportsRequest $request)
    {
          
        $data = $request->all();
        $data['jobcard_id'] = $request->jobcard_id['id'];    
        $report = $this->report->make($data); 
       
       //dd($request->input());     
       $this->report->save($report, $data);

       return $this->redirectResponse($request, __('alerts.backend.reports.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function show(Reports $report)
    {
       return $report;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function edit(Reports $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reports  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Reports $report, UpdateReportsRequest $request)
    {   
        $data = $request->input();
        $data['jobcard_id'] = $request->jobcard_id['id'];
        $report->fill($data);
        
        $this->report->save($report, $data);
           
        return $this->redirectResponse($request, __('alerts.backend.reports.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reports  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reports $report, Request $request)
    {

        $this->report->destroy($report);

        return $this->redirectResponse($request, __('alerts.backend.reports.deleted'));
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
                    $this->report->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.reports.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
