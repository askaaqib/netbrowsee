<?php

namespace App\Http\Controllers\Backend;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\ProjectRepository;

class ProjectController extends BackendController
{
    /**
     * @var JobcardRepository
     */
    protected $project;

    public function __construct(ProjectRepository $project)
    {
        //dd($jobcards);
        $this->project = $project;
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
        $query = $this->project->query();
        
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'name',
            'description',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'name',
                'description',
                'projects.created_at',
                'projects.updated_at',
            ],
                [
                    __('validation.attributes.name'),
                    __('validation.attributes.description'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'projects');
        }

        return $requestSearchQuery->result([
            'projects.id',
            'name',
            'description',
            'projects.created_at',
            'projects.updated_at',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        //dd($request->all());    
        $project = $this->project->make(
            $request->only('name','description')
        ); 
        
       $this->project->save($project, $request->input());

       return $this->redirectResponse($request, __('alerts.backend.projects.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
       return $project;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, UpdateProjectRequest $request)
    {
        $project->fill(
            $request->only('name','description')
        );
        
        $this->project->save($project, $request->input());
           
        return $this->redirectResponse($request, __('alerts.backend.projects.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Request $request)
    {
        $this->project->destroy($project);

        return $this->redirectResponse($request, __('alerts.backend.projects.deleted'));
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
                    $this->project->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.projects.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
}
