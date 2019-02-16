<?php

namespace App\Repositories;

use App\Models\ProjectManager;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\ProjectManagerRepository;

/**
 * Class EloquentProjectManagerRepository.
 */
class EloquentProjectManagerRepository extends EloquentBaseRepository implements ProjectManagerRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param ProjectManager $project_manager
     */
    public function __construct(
        ProjectManager $project_manager
    ) {
        parent::__construct($project_manager);
    }

    /**
     * @param ProjectManager                               $project_manager
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(ProjectManager $project_manager, array $input)
    {
        
        DB::transaction(function () use ($project_manager, $input) {
            if (! $project_manager->save()) {
                throw new GeneralException(__('exceptions.backend.project_managers.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param ProjectManager $project_manager
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(ProjectManager $project_manager)
    {
        if (! $project_manager->delete()) {
            throw new GeneralException(__('exceptions.backend.project_managers.delete'));
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

            /** @var ProjectManager[] $projects */
            $project_managers = $query->get();

            foreach ($project_managers as $project_manager) {
                $this->destroy($project_manager);
            }

            return true;
        });

        return true;
    }

}
