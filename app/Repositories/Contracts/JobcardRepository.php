<?php

namespace App\Repositories\Contracts;

use App\Models\Jobcard;
use App\Models\User;

/**
 * Interface JobcardRepository.
 */
interface JobcardRepository extends BaseRepository
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
     * @param \App\Models\Jobcard              $jobcard
     * @param array                         $input
     * @param \Illuminate\Http\UploadedFile $image
     *
     * @return mixed
     */
    public function saveAndPublish(Jobcard $jobcard, array $input);

    /**
     * @param Jobcard                       $jobcard
     * @param array                         $input
     * @param \Illuminate\Http\UploadedFile $image
     *
     * @return mixed
     */
    public function saveAsDraft(Jobcard $jobcard, array $input);

    /**
     * @param Jobcard $Jobcard
     *
     * @return mixed
     */
    public function destroy(Jobcard $jobcard);

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
