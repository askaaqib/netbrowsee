<?php

namespace App\Repositories;

use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\SettingsRepository;

/**
 * Class EloquentSettingsRepository.
 */
class EloquentSettingsRepository extends EloquentBaseRepository implements SettingsRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param Settings $setting
     */
    public function __construct(
        Settings $setting
    ) {
        parent::__construct($setting);
    }

    /**
     * @param Settings                               $setting
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(Settings $setting, array $input)
    {
        
        DB::transaction(function () use ($setting, $input) {
            if (! $setting->save()) {
                throw new GeneralException(__('exceptions.backend.settings.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param Settings $setting
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(Settings $setting)
    {
        if (! $setting->delete()) {
            throw new GeneralException(__('exceptions.backend.settings.delete'));
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

            /** @var Settings[] $projects */
            $settings = $query->get();

            foreach ($settings as $setting) {
                $this->destroy($setting);
            }

            return true;
        });

        return true;
    }

}
