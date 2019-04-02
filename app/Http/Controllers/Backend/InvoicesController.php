<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoices;
use App\Models\Jobcard;
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
            "company_logo",
			"invoice_status" 
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
            "invoice_status",
            'invoices.created_at',
            'invoices.updated_at',
        ]);
    }

    public function ageingreport(Request $request)
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
            //"jobcard_id",
            "project_id",
            "project_managers_id",
            "client_email",
            "invoice_description",
            "rows",
            "bank_account" ,
            'invoices.created_at',
            'invoices.updated_at',
            "company_address",
            "company_logo",
            "invoice_status" ,
            'invoices.created_at',
            'invoices.updated_at',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                "invoice_number",
            "net_amount",
            "invoice_status" 
                
                // "invoice_name",
                // "client_email",
                // "vat_amount",
                // "net_amount",
                // "total_amount",
                // "created_at",
                // "updated_at"
            ],
                [
                    __('validation.invoices.invoice_number'),
                    __('validation.invoices.net_amount'),
                    __('validation.invoices.invoice_status'),
                    // __('validation.invoices.net_amount'),
                    // __('validation.invoices.total_amount'),
                    // __('labels.created_at'),
                    // __('labels.updated_at'),
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
            "invoice_status",
            'invoices.created_at',
            'invoices.updated_at',
        ]);
    }
    
    public function vatreport(Request $request, Jobcard $jobcard)
    {

        /** @var Builder $query */
        $query = $this->invoice->query();






 $requestSearchQuery = new RequestSearchQuery($request, $query, [

            "invoice_number",
            'invoices.created_at',
            'invoices.updated_at',

           
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
               "invoice_number",
            "vat_amount",
            "total_amount",
            ],
                [
                    __('validation.invoices.invoice_number'),
                    __('validation.invoices.vat_amount'),
                    __('validation.invoices.total_amount'),
                    // __('validation.invoices.net_amount'),
                    // __('validation.invoices.total_amount'),
                    // __('labels.created_at'),
                    // __('labels.updated_at'),
                ],
                'invoices');
        }
        
        $columns = [
            "id",
            "invoice_number",
            "vat_amount",
            "total_amount",
            "invoice_status",
            "rows",
            'invoices.created_at',
            'invoices.updated_at',
        ];
        $result = $query->paginate(10, $columns);
        $result->getCollection()->transform(function ($value) use ($jobcard) {
            $value['rows'] = json_decode($value['rows'], true);
            $rows = $value['rows'];
            $value['payable_vat'] = '0.00';
            $quotes = array();
            foreach($rows as $row) {
             if(isset($row['quotation_id'])) {
                $quote_id = $row['quotation_id'];
                array_push($quotes, $quote_id);
             }
            }
            $input_vat = $jobcard::whereIn('quote_id', $quotes)->sum('vat_rate');
            $value['input_vat'] = number_format($input_vat, 2);
            unset($value['rows']);
            if($value['invoice_status'] == 'unpaid' || $value['invoice_status'] == 'overdue') {
                $value['payable_vat'] = $value['vat_amount'] + $value['input_vat'];
            }
            return $value;
        });
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoicesRequest $request)
    {
        
        $data = $request->all();
       //var_dump($data);
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
