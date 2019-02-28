<?php

namespace App\Http\Controllers\Backend;

use App\Models\Clients;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreClientsRequest;
use App\Http\Requests\UpdateClientsRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\ClientsRepository;

class ClientsController extends BackendController
{
    /**
     * @var ClientsRepository
     */
    protected $client;

    public function __construct(ClientsRepository $client)
    {
        //dd($jobcards);
        $this->clients = $client;
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
        $query = $this->clients->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'first_name',
                'last_name',
                'clients.created_at',
                'clients.updated_at',
            ],
                [
                    __('validation.clients.first_name'),
                    __('validation.clients.last_name'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'clients');
        }

        return $requestSearchQuery->result([
            'clients.id',
            'first_name',
            'last_name',
            'business_name',
            'email',
            'region',
            'street',
            'town',
            'notes',
            'primary_phone',
            'secondary_phone',
            'clients.created_at',
            'clients.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientsRequest $request)
    {
        //dd($request->all());    
        $client = $this->clients->make($request->all()); 
        
       $this->clients->save($client, $request->input());

       return $this->redirectResponse($request, __('alerts.backend.clients.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clients  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Clients $client)
    {
       return $client;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clients  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Clients $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clients  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Clients $client, UpdateClientsRequest $request)
    {
        $client->fill($request->all());
        
        $this->clients->save($client, $request->input());
           
        return $this->redirectResponse($request, __('alerts.backend.clients.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clients  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clients $client, Request $request)
    {
        $this->clients->destroy($client);

        return $this->redirectResponse($request, __('alerts.backend.clients.deleted'));
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
                    $this->clients->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.clients.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
