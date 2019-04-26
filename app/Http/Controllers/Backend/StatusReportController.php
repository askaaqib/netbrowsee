<?php

namespace App\Http\Controllers\Backend;

use App\Models\StatusReport;
use App\Models\User;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
//use App\Http\Requests\UpdateBanksRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\StatusReportRepository;
use Illuminate\Database\Eloquent\Model;


class StatusReportController extends BackendController 
{
    /**
     * @var JobcardRepository
     */
    protected $statusreport;

    public function __construct(StatusReportRepository $statusreport)
    {
        //dd($jobcards);
        $this->statusreport = $statusreport;
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
        //dd($request);
        /** @var Builder $query */
        $query = $this->contact->query();
       // dd($query);
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
                   'id', 
                   'name',
               'customer_id',
               'subject',
               'message'
        ]);

        if ($request->get('exportData')) {
            //dd($request->get('exportData'));
            return $requestSearchQuery->export([
               'id',
               'name',
               'customer_id',
               'subject',
               'message'

            ],
                [
                    __('validation.attributes.name'),
                    __('validation.attributes.subject'),
                    __('validation.attribute.message'),
                ],
                'contactus');
        }

        return $requestSearchQuery->result([

                'id',
               'customer_id',
               'subject',
               'message'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreRequest $request)
    // {
    //     //dd($request->all());  
    //     $data = $request->all();
    //     // dd($data);
    //     $bank = $this->banks->make($data); 
    //    $this->banks->save($bank, $data);

    //    return $this->redirectResponse($request, __('alerts.backend.banks.created'));
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banks  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(StatusReport $statusreport)
    {
  // dd($contactus);
       return $statusreport;
    }
//     public function getSearchValue(StatusReport $statusreport, Request $request, User $user){
//         // dd('hello');
//      $na = $user::where('name',  'LIKE', "%{$request->get('keyword')}%")->groupBy('name')->pluck('name');
// //dd($na);
// return $na;

//     }


    /**se
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brands  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactUs $contactus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brands  $brand
     * @return \Illuminate\Http\Response
     */
    // public function update(Banks $bank, UpdateBanksRequest $request)
    // {
    //     $data = $request->all();
    //     $bank->fill($data);
    //     // dd($data);
    //     // dd($bank);
        
    //     $this->banks->save($bank, $data);
           
    //     return $this->redirectResponse($request, __('alerts.backend.banks.updated'));
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brands  $brand
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Banks $bank, Request $request)
    // {
    //     $this->banks->destroy($bank);

    //     return $this->redirectResponse($request, __('alerts.backend.banks.deleted'));
    // }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    // public function batchAction(Request $request)
    // {
    //     $action = $request->get('action');
    //     $ids = $request->get('ids');
    //     switch ($action) {
    //         case 'destroy':                
    //                 $this->banks->batchDestroy($ids);
    //                 return $this->redirectResponse($request, __('alerts.backend.banks.bulk_destroyed'));
    //             break;
    //     }

    //     return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    // }
}
