<?php

namespace App\Repositories;

use App\Models\LabourRate;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\LabourRateRepository;

/**
 * Class EloquentLabourRateRepository.
 */
class EloquentLabourRateRepository extends EloquentBaseRepository implements LabourRateRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param LabourRate $labour_rate
     */
    public function __construct(
        LabourRate $labour_rate
    ) {
        parent::__construct($labour_rate);
    }

    /**
     * @param LabourRate                               $labour_rate
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(LabourRate $labour_rate, array $input)
    {
        
        DB::transaction(function () use ($labour_rate, $input) {
            if (! $labour_rate->save()) {
                throw new GeneralException(__('exceptions.backend.labour_rates.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param LabourRate $labour_rate
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(LabourRate $labour_rate)
    {
        if (! $labour_rate->delete()) {
            throw new GeneralException(__('exceptions.backend.labour_rates.delete'));
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

            /** @var LabourRate[] $projects */
            $labour_rates = $query->get();

            foreach ($labour_rates as $labour_rate) {
                $this->destroy($labour_rate);
            }

            return true;
        });

        return true;
    }

}
