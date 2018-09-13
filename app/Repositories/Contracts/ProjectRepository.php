<?php

namespace App\Repositories\Contracts;

use App\Models\Project;

/**
 * Interface ProjectRepository.
 */
interface ProjectRepository extends BaseRepository
{

    public function save(Project $project, array $input);

    /**
     * @param Project $project
     *
     * @return mixed
     */
    public function destroy(Project $project);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
