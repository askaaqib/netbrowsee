<?php

namespace App\Repositories\Contracts;

use App\Models\MaterialRate;

/**
 * Interface MaterialRateRepository.
 */
interface MaterialRateRepository extends BaseRepository
{

    public function save(MaterialRate $materials_rate, array $input);

    /**
     * @param MaterialRate $materials_rate
     *
     * @return mixed
     */
    public function destroy(MaterialRate $materials_rate);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
