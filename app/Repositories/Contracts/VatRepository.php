<?php

namespace App\Repositories\Contracts;

use App\Models\Vat;

/**
 * Interface VatRepository.
 */
interface VatRepository extends BaseRepository
{

    public function save(Vat $vat, array $input);

    /**
     * @param Vat $vat
     *
     * @return mixed
     */
    public function destroy(Vat $vat);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
