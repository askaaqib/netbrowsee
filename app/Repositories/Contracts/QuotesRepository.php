<?php

namespace App\Repositories\Contracts;

use App\Models\Quotes;

/**
 * Interface ProjectQuotesRepository.
 */
interface QuotesRepository extends BaseRepository
{

    public function save(Quotes $quote, array $input);

    /**
     * @param Quotes $quote
     *
     * @return mixed
     */
    public function destroy(Quotes $quote);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
