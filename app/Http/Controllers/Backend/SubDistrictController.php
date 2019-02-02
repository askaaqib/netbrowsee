<?php
namespace App\Http\Controllers\Backend;

use App\Models\SubDistrict;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreSubDistrictRequest;
use App\Http\Requests\UpdateSubDistrictRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\SubDistrictRepository;

class SubDistrictController extends BackendController
{
    /**
     * @var DistrictRepository
     */
    protected $district;

    public function __construct(SubDistrictRepository $SubDistrict)
    {
        $this->subdistrict = $SubDistrict;

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
        $query = $this->subdistrict->query();
        // dd($query);
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            
            'name',
            
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([                
                'name',
               'subdistrict.created_at',
                'subdistrict.updated_at'
               
            ],
                [
                    __('validation.SubDistrict.name'),
                ],
                'subdistrict');
        }
        return $requestSearchQuery->result([
            'id',
            'name',
            'district_id',
            'subdistrict.created_at',
            'subdistrict.updated_at'
           
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubDistrictRequest $request)
    {
       
       // dd($request->all());   
        $data = $request->input();
        
        //dd($data);
        //$data['jobcard_id'] = $request->jobcard_id['id'];    
        $subdistrict = $this->subdistrict->make($data); 
       //dd($subdistrict);
       //dd($request->input());     
       $this->subdistrict->save($subdistrict, $data);

       return $this->redirectResponse($request, __('alerts.backend.SubDistrict.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubDistrict  $SubDistrict
     * @return \Illuminate\Http\Response
     */
    public function show(SubDistrict $subdistrict)
    {
       return $subdistrict;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubDistrict  $SubDistrict
     * @return \Illuminate\Http\Response
     */
    public function edit(SubDistrict $subdistrict)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubDistrict  $subdistrict
     * @return \Illuminate\Http\Response
     */
    public function update(SubDistrict $subdistrict, UpdateSubDistrictRequest $request)
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

        $subdistrict->fill($data);
        $this->subdistrict->save($subdistrict, $data);
        return $this->redirectResponse($request, __('alerts.backend.SubDistrict.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubDistrict  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubDistrict $subdistrict, Request $request)
    {
   //dd($subdistrict);
        $this->subdistrict->destroy($subdistrict);

        return $this->redirectResponse($request, __('alerts.backend.SubDistrict.deleted'));
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
        //dd($ids);
        switch ($action) {
            case 'destroy':                
                    $this->subdistrict->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.SubDistrict.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
