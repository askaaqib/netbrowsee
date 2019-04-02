<?php

namespace App\Repositories;

use App\Models\StatusReport;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\ContactRepository;

/**
 * Class EloquentBanksRepository.
 */
class EloquentStatusReportRepository extends EloquentBaseRepository implements ContactRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param StatusReport $statusreport
     */
    public function __construct(
        StatusReport $statusreport
    ) {
        parent::__construct($statusreport);
    }

    /**
     * @param StatusReport                       $statusreport
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(StatusReport $statusreport, array $input)
    {
        DB::transaction(function () use ($StatusReport, $input) {
            if (! $statusreport->save()) {
                throw new GeneralException(__('exceptions.backend.contact.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param StatusReport $statusreport
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(StatusReport $statusreport)
    {
        if (! $statusreport->delete()) {
            throw new GeneralException(__('exceptions.backend.contact.delete'));
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
        $query = $this->query()->whereIn('Bank_ID', $ids);

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

            /** @var Banks[] $bank */
            $bank = $query->get();

            foreach ($contact as $contact) {
                $this->destroy($contact);
            }

            return true;
        });

        return true;
    }

}
