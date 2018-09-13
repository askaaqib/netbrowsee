<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProjectManager;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreProjectManagerRequest;
use App\Http\Requests\UpdateProjectManagerRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\ProjectManagerRepository;

class ProjectManagerController extends BackendController
{
    /**
     * @var JobcardRepository
     */
    protected $project_manager;

    public function __construct(ProjectManagerRepository $project_manager)
    {
        //dd($jobcards);
        $this->project_manager = $project_manager;
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
        $query = $this->project_manager->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'name',
            'description',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'name',
                'description',
                'project_managers.created_at',
                'project_managers.updated_at',
            ],
                [
                    __('validation.attributes.name'),
                    __('validation.attributes.description'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'project_managers');
        }

        return $requestSearchQuery->result([
            'project_managers.id',
            'name',
            'description',
            'project_managers.created_at',
            'project_managers.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectManagerRequest $request)
    {
        //dd($request->all());    
        $project_manager = $this->project_manager->make(
            $request->only('name','description')
        ); 
        
       $this->project_manager->save($project_manager, $request->input());

       return $this->redirectResponse($request, __('alerts.backend.project_managers.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProjectManager  $project_manager
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectManager $project_manager)
    {
       return $project_manager;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectManager  $project_manager
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectManager $project_manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjectManager  $project_manager
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectManager $project_manager, UpdateProjectManagerRequest $request)
    {
        $project_manager->fill(
            $request->only('name','description')
        );
        
        $this->project_manager->save($project_manager, $request->input());
           
        return $this->redirectResponse($request, __('alerts.backend.project_managers.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectManager  $project_manager
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectManager $project_manager, Request $request)
    {

        $this->project_manager->destroy($project_manager);

        return $this->redirectResponse($request, __('alerts.backend.project_managers.deleted'));
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
                    $this->project_manager->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.projects.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
