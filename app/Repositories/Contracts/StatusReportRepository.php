<?php

namespace App\Repositories\Contracts;

use App\Models\StatusReport;

/**
 * Interface BanksRepository.
 */
interface StatusReportRepository extends BaseRepository
{

    public function save(StatusReport $statusreport, array $input);

    /**
     * @param ContactsUs $contactusus
     *
     * @return mixed
     */
    public function destroy(StatusReport $statusreport);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
