<?php

namespace App\Http\Controllers\Backend;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\SettingsRepository;

class SettingsController extends BackendController
{
    /**
     * @var SettingsRepository
     */
    protected $setting;

    public function __construct(SettingsRepository $Settings)
    {
        //dd($jobcards);
        $this->setting = $Settings;
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
        $query = $this->setting->query();

        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'company_name',
            'company_address',
            'bank_account',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'company_name',
                'company_address',
                'bank_account',
            ],
                [
                    __('validation.settings.company_name'),
                    __('validation.settings.company_address'),
                    __('validation.settings.Bank Account'),
                ],
                'Settings');
        }

        return $requestSearchQuery->result([
            'id',
            'company_name',
            'company_address',
            'company_logo',
            'bank_account',
            'quote_ref_start',
            'quote_vat',
            'settings.created_at',
            'settings.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingsRequest $request)
    {

       // dd($request->all());
        $data = $request->input();
        $new_logo = $request->selectedLogo;

        if($new_logo){
            $logo_name_random = rand(0,9999). $new_logo->getClientOriginalName();
            $logo_name = str_replace(' ', '', $logo_name_random);
            $data['company_logo'] = $logo_name;

            // remove old file
            $new_logo->move(public_path('uploads'),$logo_name);
        }

        //$data['jobcard_id'] = $request->jobcard_id['id'];
        $setting = $this->setting->make($data);

       //dd($request->input());
       $this->setting->save($setting, $data);

       return $this->redirectResponse($request, __('alerts.backend.settings.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Settings  $Settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $setting)
    {
       return $setting;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $Settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Settings $setting, UpdateSettingsRequest $request)
    {
        // $logo = $request->selectedLogo;
        // $logo_name_random = rand(0,9999). $logo->getClientOriginalName();
        // $logo_name = str_replace(' ', '', $logo_name_random);
        // $logo->move(public_path('uploads'),$logo_name);
dd($request->all());
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

        $setting->fill($data);
        $this->setting->save($setting, $data);
        return $this->redirectResponse($request, __('alerts.backend.settings.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settings  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $setting, Request $request)
    {

        $this->setting->destroy($setting);

        return $this->redirectResponse($request, __('alerts.backend.settings.deleted'));
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
                    $this->setting->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.settings.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
