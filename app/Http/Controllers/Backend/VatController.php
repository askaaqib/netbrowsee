<?php

namespace App\Http\Controllers\Backend;

use App\Models\Vat;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreVatRequest;
use App\Http\Requests\UpdateVatRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\VatRepository;

class VatController extends BackendController
{
    /**
     * @var VatRepository
     */
    protected $vat;

    public function __construct(VatRepository $vat)
    {
        //dd($jobcards);
        $this->vat = $vat;
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
        $query = $this->vat->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'name',
            'rate',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'name',
                'rate',
                'vat.created_at',
                'vat.updated_at',
            ],
                [
                    __('validation.vat.name'),
                    __('validation.vat.rate'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'vat');
        }

        return $requestSearchQuery->result([
            'vat.id',
            'name',
            'rate',
            'vat.created_at',
            'vat.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVatRequest $request)
    {
        //dd($request->all());    
        $vat = $this->vat->make(
            $request->only('name','rate')
        ); 
        
       $this->vat->save($vat, $request->input());

       return $this->redirectResponse($request, __('alerts.backend.vat.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vat  $vat
     * @return \Illuminate\Http\Response
     */
    public function show(Vat $vat)
    {
       return $vat;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vat  $vat
     * @return \Illuminate\Http\Response
     */
    public function edit(Vat $vat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vat  $vat
     * @return \Illuminate\Http\Response
     */
    public function update(Vat $vat, UpdateVatRequest $request)
    {
        $vat->fill(
            $request->only('name','rate')
        );
        
        $this->vat->save($vat, $request->input());
           
        return $this->redirectResponse($request, __('alerts.backend.vat.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vat  $vat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vat $vat, Request $request)
    {

        $this->vat->destroy($vat);

        return $this->redirectResponse($request, __('alerts.backend.vat.deleted'));
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
                    $this->vat->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.vat.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
