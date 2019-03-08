<?php

namespace App\Repositories\Contracts;

use App\Models\Reports;

/**
 * Interface ProjectProjectManagerRepository.
 */
interface ReportsRepository extends BaseRepository
{

    public function save(Reports $report, array $input);

    /**
     * @param Reports $report
     *
     * @return mixed
     */
    public function destroy(Reports $report);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
