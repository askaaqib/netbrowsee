<?php

namespace App\Repositories\Contracts;

use App\Models\Invoices;

/**
 * Interface ProjectProjectManagerRepository.
 */
interface InvoicesRepository extends BaseRepository
{

    public function save(Invoices $invoice, array $input);

    /**
     * @param Invoices $invoice
     *
     * @return mixed
     */
    public function destroy(Invoices $invoice);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
