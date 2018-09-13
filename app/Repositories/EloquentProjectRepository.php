<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\ProjectRepository;

/**
 * Class EloquentProjectRepository.
 */
class EloquentProjectRepository extends EloquentBaseRepository implements ProjectRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param Project $project
     */
    public function __construct(
        Project $project
    ) {
        parent::__construct($project);
    }

    /**
     * @param Project                               $project
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(Project $project, array $input)
    {

        DB::transaction(function () use ($project, $input) {
            if (! $project->save()) {
                throw new GeneralException(__('exceptions.backend.projects.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param Project $project
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(Project $project)
    {
        if (! $project->delete()) {
            throw new GeneralException(__('exceptions.backend.projects.delete'));
        }

        return true;
    }

    /**
     * @param array $ids
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function batchQuery(array $ids)
    {
        $query = $this->query()->whereIn('id', $ids);

        return $query;
    }

    /**
     * @param array $ids
     *
     * @throws \Exception|\Throwable
     *
     * @return mixed
     */
    public function batchDestroy(array $ids)
    {
        DB::transaction(function () use ($ids) {
            $query = $this->batchQuery($ids);            

            /** @var Project[] $projects */
            $projects = $query->get();

            foreach ($projects as $project) {
                $this->destroy($project);
            }

            return true;
        });

        return true;
    }

}
