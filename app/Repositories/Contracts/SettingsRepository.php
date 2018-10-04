<?php

namespace App\Repositories\Contracts;

use App\Models\Settings;

/**
 * Interface ProjectProjectManagerRepository.
 */
interface SettingsRepository extends BaseRepository
{

    public function save(Settings $setting, array $input);

    /**
     * @param Settings $setting
     *
     * @return mixed
     */
    public function destroy(Settings $setting);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
