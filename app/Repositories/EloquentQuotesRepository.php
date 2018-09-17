<?php

namespace App\Repositories;

use App\Models\Quotes;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\QuotesRepository;

/**
 * Class EloquentQuotesRepository.
 */
class EloquentQuotesRepository extends EloquentBaseRepository implements QuotesRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param Quotes $quote
     */
    public function __construct(
        Quotes $quote
    ) {
        parent::__construct($quote);
    }

    /**
     * @param Quotes                               $quote
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(Quotes $quote, array $input)
    {
        
        DB::transaction(function () use ($quote, $input) {
            if (! $quote->save()) {
                throw new GeneralException(__('exceptions.backend.quotes.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param Quotes $quote
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(Quotes $quote)
    {
        if (! $quote->delete()) {
            throw new GeneralException(__('exceptions.backend.quotes.delete'));
        }

        return true;
    }

    /**
     * @param array $ids
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function batchQuery(array $ids)
    {
        $query = $this->query()->whereIn('id', $ids);

        return $query;
    }

    /**
     * @param array $ids
     *
     * @throws \Exception|\Throwable
     *
     * @return mixed
     */
    public function batchDestroy(array $ids)
    {
        DB::transaction(function () use ($ids) {
            $query = $this->batchQuery($ids);            

            /** @var Quotes[] $projects */
            $quotes = $query->get();

            foreach ($quotes as $quote) {
                $this->destroy($quote);
            }

            return true;
        });

        return true;
    }

}
