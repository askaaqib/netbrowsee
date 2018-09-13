<?php

namespace App\Repositories\Contracts;

use App\Models\Quotes;
use App\Models\User;

/**
 * Interface QuotesRepository.
 */
interface QuotesRepository extends BaseRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function published();

    /**
     * @param \App\Models\User $user
     *
     * @return mixed
     *
     * @internal param \App\Models\Tag $tag
     */
    public function publishedByOwner(User $user);


    /**
     * @param \App\Models\Quotes              $Quotes
     * @param array                         $input
     * @param \Illuminate\Http\UploadedFile $image
     *
     * @return mixed
     */
    public function saveAndPublish(Quotes $Quotes, array $input);

    /**
     * @param Quotes                       $Quotes
     * @param array                         $input
     * @param \Illuminate\Http\UploadedFile $image
     *
     * @return mixed
     */
    public function saveAsDraft(Quotes $Quotes, array $input);

    /**
     * @param Quotes $Quotes
     *
     * @return mixed
     */
    public function destroy(Quotes $Quotes);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchPublish(array $ids);
}
