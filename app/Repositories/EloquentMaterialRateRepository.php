<?php

namespace App\Repositories;

use App\Models\MaterialRate;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\MaterialRateRepository;

/**
 * Class EloquentMaterialRateRepository.
 */
class EloquentMaterialRateRepository extends EloquentBaseRepository implements MaterialRateRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param MaterialRate $materials_rates
     */
    public function __construct(
        MaterialRate $materials_rate
    ) {
        parent::__construct($materials_rate);
    }

    /**
     * @param MaterialRate                               $materials_rates
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(MaterialRate $materials_rate, array $input)
    {
        
        DB::transaction(function () use ($materials_rate, $input) {
            if (! $materials_rate->save()) {
                throw new GeneralException(__('exceptions.backend.materials_rates.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param MaterialRate $materials_rates
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(MaterialRate $materials_rate)
    {
        if (! $materials_rate->delete()) {
            throw new GeneralException(__('exceptions.backend.materials_rates.delete'));
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

            /** @var MaterialRate[] $projects */
            $materials_rates = $query->get();

            foreach ($materials_rates as $materials_rate) {
                $this->destroy($materials_rate);
            }

            return true;
        });

        return true;
    }

}
