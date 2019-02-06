<?php

namespace App\Repositories;

use App\Models\Jobcard;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\Models\Media;
use App\Repositories\Contracts\JobcardRepository;

/**
 * Class EloquentJobcardRepository.
 */
class EloquentJobcardRepository extends EloquentBaseRepository implements JobcardRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param Jobcard $jobcard
     */
    public function __construct(
        Jobcard $jobcard
    ) {
        parent::__construct($jobcard);
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
     * @param Jobcard                               $jobcard
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function saveAndPublish(Jobcard $jobcard, array $input)
    {
                
        // $jobcard->status = Jobcard::PUBLISHED;
        // dd($input);
            
        return $this->save($jobcard, $input);
    }

    /**
     * @param Jobcard                               $jobcard
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function saveAsDraft(Jobcard $jobcard, array $input)
    {
        // $jobcard->status = Jobcard::DRAFT;

        return $this->save($jobcard, $input);
    }

    /**
     * @param Jobcard                               $jobcard
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    private function save(Jobcard $jobcard, array $input)
    {
        if ($jobcard->exists) {
            
            if (! Gate::check('update', $jobcard)) {
                
                throw new GeneralException(__('exceptions.backend.jobcards.save'));
            }
        } else {
            //$jobcard->user_id = auth()->id();
        }

        if (Jobcard::PUBLISHED === $jobcard->status && ! Gate::check('publish jobcards')) {
            // User with no publish permissions must go to moderation awaiting
            $jobcard->status = Jobcard::PENDING;
        }

        DB::transaction(function () use ($jobcard, $input) {
            if (! $jobcard->save()) {
                throw new GeneralException(__('exceptions.backend.jobcards.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param Jobcard $jobcard
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(Jobcard $jobcard)
    {
        if (! $jobcard->delete()) {
            throw new GeneralException(__('exceptions.backend.jobcards.delete'));
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

            /** @var Jobcard[] $jobcards */
            $jobcards = $query->get();

            foreach ($jobcards as $jobcard) {
                $this->destroy($jobcard);
            }

            return true;
        });

        return true;
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
