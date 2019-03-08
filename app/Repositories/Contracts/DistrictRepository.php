<?php

namespace App\Repositories\Contracts;

use App\Models\District;

/**
 * Interface DistrictRepository.
 */
interface DistrictRepository extends BaseRepository
{

    public function save(District $district, array $input);

    /**
     * @param District $district
     *
     * @return mixed
     */
    public function destroy(District $district);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
