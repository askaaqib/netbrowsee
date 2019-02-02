<?php

namespace App\Repositories;

use App\Models\District;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\DistrictRepository;

/**
 * Class EloquentDistrictRepository.
 */
class EloquentDistrictRepository extends EloquentBaseRepository implements DistrictRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param District $district
     */
    public function __construct(
        District $district
    ) {
        parent::__construct($district);
    }

    /**
     * @param District                               $district
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(District $district, array $input)
    {

        DB::transaction(function () use ($district, $input) {
            if (! $district->save()) {
                throw new GeneralException(__('exceptions.backend.Districts.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param District $district
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(District $district)
    {
        if (! $district->delete()) {
            throw new GeneralException(__('exceptions.backend.Districts.delete'));
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

            /** @var District[] $districts */
            $districts = $query->get();

            foreach ($districts as $district) {
                $this->destroy($district);
            }

            return true;
        });

        return true;
    }

}
