<?php

namespace App\Repositories;

use App\Models\Quotes;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\Models\Media;
use App\Repositories\Contracts\QuotesRepository;

/**
 * Class EloquentQuotesRepository.
 */
class EloquentQuotesRepository extends EloquentBaseRepository implements QuotesRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param Quotes $quotes
     */
    public function __construct(
        Quotes $quotes
    ) {
        parent::__construct($quotes);
    }

    /**
     * @return mixed
     */
    public function published()
    {
       
    }

    /**
     * @param Tag $tag
     *
     * @return mixed
     */
    public function publishedByTag(Tag $tag)
    {
    }

    /**
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function publishedByOwner(User $user)
    {
        
    }

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function findBySlug($slug)
    {
        
    }

    /**
     * @param Quotes                               
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function saveAndPublish(Quotes $quotes, array $input)
    {
        return $this->save($quotes, $input);
    }

    /**
     * @param quotes                               $quotes
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function saveAsDraft(Quotes $quotes, array $input)
    {

        return $this->save($quotes, $input);
    }

    /**
     * @param Quotes                               $Quotes
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    private function save(Quotes $quotes, array $input)
    {
        if ($quotes->exists) {
            if (! Gate::check('update', $quotes)) {
                throw new GeneralException(__('exceptions.backend.quotes.save'));
            }
        } else {
            //$quotes->user_id = auth()->id();
        }

        DB::transaction(function () use ($quotes, $input) {

            if (! $quotes->save()) {
                throw new GeneralException(__('exceptions.backend.quotes.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param quotes $quotes
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(Quotes $quotes)
    {
        if (! $quotes->delete()) {
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
        
    }

    /**
     * @param array $ids
     *
     * @throws \Throwable
     * @throws \Exception
     *
     * @return mixed
     */
    public function batchPublish(array $ids)
    {
       
    }

    /**
     * @param array $ids
     *
     * @throws \Throwable
     * @throws \Exception
     *
     * @return mixed
     */
    public function batchPin(array $ids)
    {
        
    }

    /**
     * @param array $ids
     *
     * @throws \Throwable
     * @throws \Exception
     *
     * @return mixed
     */
    public function batchPromote(array $ids)
    {
        
    }
}
