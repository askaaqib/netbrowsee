<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreInvoicesRequest;
use App\Http\Requests\UpdateInvoicesRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\InvoicesRepository;

class InvoicesController extends BackendController
{
    /**
     * @var InvoicesRepository
     */
    protected $invoice;

    public function __construct(InvoicesRepository $invoices)
    {
        //dd($jobcards);
        $this->invoice = $invoices;
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
        $query = $this->invoice->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
			"invoice_number",
			"invoice_digit",
			"invoice_name",
			"vat_amount",
			"net_amount",
			"total_amount",
			"vat_rates",
			"jobcard_id",
			"project_id",
			"project_managers_id",
			"client_email",
			"invoice_description",
			"rows",
			"bank_account" ,
			"company_address",
			"company_logo" 
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                "invoice_name",
                "client_email",
                "vat_amount",
                "net_amount",
                "total_amount",
                "created_at",
                "updated_at"
            ],
                [
                    __('validation.invoices.invoice_name'),
                    __('validation.invoices.client_email'),
                    __('validation.invoices.vat_amount'),
                    __('validation.invoices.net_amount'),
                    __('validation.invoices.total_amount'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'invoices');
        }

        return $requestSearchQuery->result([
            "id",
            "invoice_name",
            "invoice_number",
			"invoice_digit",
            "client_email",
            "vat_amount",
            "net_amount",
            "total_amount",
            'invoices.created_at',
            'invoices.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoicesRequest $request)
    {
        //dd($request->all());
        $data = $request->all();
        $data['rows'] = json_encode($request->rows);
       
        $invoice = $this->invoice->make($data); 
       
       //dd($request->input());     
       $this->invoice->save($invoice, $data);

       return $this->redirectResponse($request, __('alerts.backend.invoices.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoices  $Invoices
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices $invoice)
    {
       return $invoice;
    }

    public function view(Invoices $invoice)
    {
       return $invoice;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoices  $Invoices
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoices  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Invoices $invoice, UpdateInvoicesRequest $request)
    {   
        $data = $request->all();
        $data['rows'] = json_encode($request->rows);
        $invoice->fill($data);
        
        $this->invoice->save($invoice, $data);
           
        return $this->redirectResponse($request, __('alerts.backend.invoices.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoices  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoices $invoice, Request $request)
    {

        $this->invoice->destroy($invoice);

        return $this->redirectResponse($request, __('alerts.backend.invoices.deleted'));
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
                    $this->invoice->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.invoices.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
