<?php

namespace App\Repositories;

use App\Models\Vat;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\VatRepository;

/**
 * Class EloquentVatRepository.
 */
class EloquentVatRepository extends EloquentBaseRepository implements VatRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param Vat $vat
     */
    public function __construct(
        Vat $vat
    ) {
        parent::__construct($vat);
    }

    /**
     * @param Vat                               $vat
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(Vat $vat, array $input)
    {
        
        DB::transaction(function () use ($vat, $input) {
            if (! $vat->save()) {
                throw new GeneralException(__('exceptions.backend.vat.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param Vat $vat
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(Vat $vat)
    {
        if (! $vat->delete()) {
            throw new GeneralException(__('exceptions.backend.vat.delete'));
        }

        return true;
    }

    /**
     * @param array $id Vat
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

            /** @var Vat[] $projects */
            $vats = $query->get();

            foreach ($vats as $vat) {
                $this->destroy($vat);
            }

            return true;
        });

        return true;
    }

}
