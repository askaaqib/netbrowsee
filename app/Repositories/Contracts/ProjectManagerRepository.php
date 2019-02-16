<?php

namespace App\Repositories\Contracts;

use App\Models\ProjectManager;

/**
 * Interface ProjectProjectManagerRepository.
 */
interface ProjectManagerRepository extends BaseRepository
{

    public function save(ProjectManager $project_manager, array $input);

    /**
     * @param ProjectManager $project_manager
     *
     * @return mixed
     */
    public function destroy(ProjectManager $project_manager);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
