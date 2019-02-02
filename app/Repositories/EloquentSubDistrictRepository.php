<?php

namespace App\Repositories;

use App\Models\SubDistrict;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\SubDistrictRepository;

/**
 * Class EloquentDistrictRepository.
 */
class EloquentSubDistrictRepository extends EloquentBaseRepository implements SubDistrictRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param District $district
     */
    public function __construct(
        SubDistrict $subdistrict
    ) {
        parent::__construct($subdistrict);
    }

    /**
     * @param SubDistrict                               $subdistrict
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(SubDistrict $subdistrict, array $input)
    {

        DB::transaction(function () use ($subdistrict, $input) {
            if (! $subdistrict->save()) {
                throw new GeneralException(__('exceptions.backend.SubDistricts.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param SubDistrict $subdistrict
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(SubDistrict $subdistrict)
    {
        if (! $subdistrict->delete()) {
            throw new GeneralException(__('exceptions.backend.SubDistricts.delete'));
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

            /** @var SubDistrict[] $subdistricts */
            $subdistricts = $query->get();

            foreach ($subdistricts as $subdistrict) {
                $this->destroy($subdistrict);
            }

            return true;
        });

        return true;
    }

}
