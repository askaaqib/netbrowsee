<?php

namespace App\Repositories;

use App\Models\Clients;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\ClientsRepository;

/**
 * Class ClientsRepository.
 */
class EloquentClientsRepository extends EloquentBaseRepository implements ClientsRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param Clients $clients
     */
    public function __construct(
        Clients $clients
    ) {
        parent::__construct($clients);
    }

    /**
     * @param Clients                               $clients
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(Clients $clients, array $input)
    {
        
        DB::transaction(function () use ($clients, $input) {
            if (! $clients->save()) {
                throw new GeneralException(__('exceptions.backend.clients.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param Clients $clients
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(Clients $clients)
    {
        if (! $clients->delete()) {
            throw new GeneralException(__('exceptions.backend.clients.delete'));
        }

        return true;
    }

    /**
     * @param array $id Clients
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

            /** @var Clients[] $projects */
            $clientss = $query->get();

            foreach ($clientss as $clients) {
                $this->destroy($clients);
            }

            return true;
        });

        return true;
    }

}
