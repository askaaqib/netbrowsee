<?php

namespace App\Http\Controllers\Backend;

use App\Models\Quotes;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreQuotesRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\QuotesRepository;


class QuotesController extends BackendController
{
    /**
     * @var QuotesRepository
     */
    protected $quotes;

    /**
     * Create a new controller instance.
     *
     *
     * @param \App\Repositories\Contracts\QuotesRepository $quotes
     */
    public function __construct(QuotesRepository $quotes)
    {
        //dd($quotes);
        $this->quotes = $quotes;
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
        $query = $this->quotes->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'quotation_number',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'quotation_number',
                'quotation_name',
            ],
                [
                    __('validation.quotes.quotes_num'),
                    __('validation.quotes.name'),

                ],
                'quotes');
        }

        return $requestSearchQuery->result([
            'quotes.id',
            'quotation_number',
            'quotation_name',
            'travelling_time',
            'travelling_km',
            'vat_amount',
            'net_amount',
            'total_amount',
            'quotes.created_at',
            'quotes.updated_at',
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
     * @param StoreQuotesRequest $request
     *
     * @return mixed
     */
    public function store(StoreQuotesRequest $request)
    {
        
        //dd($request->all());    
        $quotes = $this->quotes->make(
            $request->all()
        ); 
        
        $this->quotes->saveAndPublish($quotes, $request->input());
        
        return $this->redirectResponse($request, __('alerts.backend.quotes.created'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getLastestquotes()
    {
        $query = $this->quotes->query();        

        return $query->orderByDesc('created_at')->limit(10)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\quotes  $quotes
     * @return \Illuminate\Http\Response
     */
    public function show(quotes $quotes)
    {
        return $quotes;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\quotes  $quotes
     * @return \Illuminate\Http\Response
     */
    public function edit(quotes $quotes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\quotes  $quotes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, quotes $quotes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\quotes  $quotes
     * @return \Illuminate\Http\Response
     */
    public function destroy(quotes $quotes)
    {
        //
    }
}
