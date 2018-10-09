<?php

namespace App\Http\Controllers\Backend;

use App\Models\Quotes;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreQuotesRequest;
use App\Http\Requests\UpdateQuotesRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\QuotesRepository;

class QuotesController extends BackendController
{
    /**
     * @var JobcardRepository
     */
    protected $quote;


    public function __construct(QuotesRepository $quote)
    {
        //dd($jobcards);
        $this->quote = $quote;
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
        $query = $this->quote->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'quotation_number',
            'quotation_name',
            'quotation_digit',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'quotation_number',
                'quotation_name',
                'quotes.created_at',
                'quotes.updated_at',
            ],
                [
                    __('validation.attributes.quotation_number'),
                    __('validation.attributes.quotation_name'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'quotes');
        }

        return $requestSearchQuery->result([
            'quotes.id',
            'quotation_number',
            'quotation_name',
            'quotation_digit',
            'quotes.created_at',
            'quotes.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuotesRequest $request)
    {
        $data = $request->all();
        // dd($data);
        $data['rows'] = json_encode($request->rows);
        $quote = $this->quote->make($data); 
        
       $this->quote->save($quote, $data);

       return $this->redirectResponse($request, __('alerts.backend.quotes.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quotes  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quotes $quote)
    {
       return $quote;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quotes  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotes $quote)
    {
        //
    }

    public function view(Quotes $quote)
    {
       return $quote;
    }
    
    public function printPdf(Quotes $quote)
    {
       return $quote;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quotes  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Quotes $quote, UpdateQuotesRequest $request)
    {   
        $data = $request->all();
        // dd($data);
        $data['rows'] = json_encode($request->rows);
        $quote->fill($data);
        
        $this->quote->save($quote, $data);
           
        return $this->redirectResponse($request, __('alerts.backend.quotes.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quotes  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotes $quote, Request $request)
    {

        $this->quote->destroy($quote);

        return $this->redirectResponse($request, __('alerts.backend.quotes.deleted'));
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
                    $this->quote->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.quotes.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
