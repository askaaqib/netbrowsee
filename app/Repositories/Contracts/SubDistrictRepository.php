<?php

namespace App\Repositories\Contracts;

use App\Models\SubDistrict;

/**
 * Interface DistrictRepository.
 */
interface SubDistrictRepository extends BaseRepository
{

    public function save(SubDistrict $subdistrict, array $input);

    /**
     * @param SubDistrict $subdistrict
     *
     * @return mixed
     */
    public function destroy(SubDistrict $subdistrict);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
