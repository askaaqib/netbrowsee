<?php

namespace App\Http\Controllers\Backend;

use App\Models\MaterialRate;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreMaterialRateRequest;
use App\Http\Requests\UpdateMaterialRateRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\MaterialRateRepository;

class MaterialRateController extends BackendController
{
    /**
     * @var MaterialRateRepository
     */
    protected $materials_rates;

    public function __construct(MaterialRateRepository $materials_rates)
    {
        //dd($jobcards);
        $this->materials_rates = $materials_rates;
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
        $query = $this->materials_rates->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'name',
            'rate',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'name',
                'rate',
                'materials_rates.created_at',
                'materials_rates.updated_at',
            ],
                [
                    __('validation.materials_rates.name'),
                    __('validation.materials_rates.rate'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'materials_rates');
        }

        return $requestSearchQuery->result([
            'materials_rates.id',
            'name',
            'rate',
            'materials_rates.created_at',
            'materials_rates.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaterialRateRequest $request)
    {
        //dd($request->all());    
        $materials_rates = $this->materials_rates->make(
            $request->only('name','rate')
        ); 
        
       $this->materials_rates->save($materials_rates, $request->input());

       return $this->redirectResponse($request, __('alerts.backend.materials_rates.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialRate  $materials_rates
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialRate $materials_rate)
    {
       return $materials_rate;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialRate  $materials_rates
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialRate $materials_rates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialRate  $materials_rates
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialRate $materials_rates, UpdateMaterialRateRequest $request)
    {
        $materials_rates->fill(
            $request->only('name','rate')
        );
        
        $this->materials_rates->save($materials_rates, $request->input());
           
        return $this->redirectResponse($request, __('alerts.backend.materials_rates.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialRate  $materials_rates
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialRate $materials_rates, Request $request)
    {

        $this->materials_rates->destroy($materials_rates);

        return $this->redirectResponse($request, __('alerts.backend.materials_rates.deleted'));
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
                    $this->materials_rates->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.materials_rates.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
