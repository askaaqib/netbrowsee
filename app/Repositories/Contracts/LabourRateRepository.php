<?php

namespace App\Repositories\Contracts;

use App\Models\LabourRate;

/**
 * Interface LabourRateRepository.
 */
interface LabourRateRepository extends BaseRepository
{

    public function save(LabourRate $labour_rate, array $input);

    /**
     * @param LabourRate $labour_rate
     *
     * @return mixed
     */
    public function destroy(LabourRate $labour_rate);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
