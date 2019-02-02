<?php

namespace App\Http\Controllers\Backend;

use App\Models\District;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\DistrictRepository;

class DistrictController extends BackendController
{
    /**
     * @var DistrictRepository
     */
    protected $district;

    public function __construct(DistrictRepository $District)
    {
        $this->district = $District;

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
        $query = $this->district->query();
        // dd($query);
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            
            'name',
            
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([                
                'name',
               'district.created_at',
                'district.updated_at'
               
            ],
                [
                    __('validation.District.name'),
                ],
                'district');
        }
        return $requestSearchQuery->result([
            'id',
            'name',
            'district.created_at',
            'district.updated_at'
           
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDistrictRequest $request)
    {
       
       // dd($request->all());   
        $data = $request->input();
        
        //dd($data);
        //$data['jobcard_id'] = $request->jobcard_id['id'];    
        $district = $this->district->make($data); 
       
       //dd($request->input());     
       $this->district->save($district, $data);

       return $this->redirectResponse($request, __('alerts.backend.District.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\District  $District
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
       return $district;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $District
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(District $district, UpdateDistrictRequest $request)
    {   
        // $logo = $request->selectedLogo;
        // $logo_name_random = rand(0,9999). $logo->getClientOriginalName();
        // $logo_name = str_replace(' ', '', $logo_name_random);
        // $logo->move(public_path('uploads'),$logo_name);

        $data = $request->input();

        $new_logo = $request->selectedLogo;
        $old_logo = $request->company_logo;

        if($new_logo){
            $logo_name_random = rand(0,9999). $new_logo->getClientOriginalName();
            $logo_name = str_replace(' ', '', $logo_name_random);
            $data['company_logo'] = $logo_name; 
            
            if(file_exists(public_path('uploads/').$old_logo)){
                unlink(public_path('uploads/').$old_logo);
            }
             // remove old file 
            $new_logo->move(public_path('uploads'),$logo_name);
        }

        $district->fill($data);
        $this->district->save($district, $data);
        return $this->redirectResponse($request, __('alerts.backend.District.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\District  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district, Request $request)
    {

        $this->district->destroy($district);

        return $this->redirectResponse($request, __('alerts.backend.District.deleted'));
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
                    $this->district->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.District.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
