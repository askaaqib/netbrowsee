<?php

namespace App\Repositories\Contracts;

use App\Models\Clients;

/**
 * Interface ProjectProjectManagerRepository.
 */
interface ClientsRepository extends BaseRepository
{

    public function save(Clients $clients, array $input);

    /**
     * @param Clients $clients
     *
     * @return mixed
     */
    public function destroy(Clients $clients);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function batchDestroy(array $ids);
}
