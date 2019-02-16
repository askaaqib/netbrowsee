<?php

namespace App\Repositories;

use App\Models\Reports;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\ReportsRepository;

/**
 * Class EloquentReportsRepository.
 */
class EloquentReportsRepository extends EloquentBaseRepository implements ReportsRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param Reports $report
     */
    public function __construct(
        Reports $reports
    ) {
        parent::__construct($reports);
    }

    /**
     * @param Reports                               $report
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(Reports $report, array $input)
    {
        //dd($report,$input);
        DB::transaction(function () use ($report, $input) {
            if (! $report->save()) {
                throw new GeneralException(__('exceptions.backend.reports.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param Reports $report
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(Reports $report)
    {
        if (! $report->delete()) {
            throw new GeneralException(__('exceptions.backend.reports.delete'));
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

            /** @var Reports[] $projects */
            $reports = $query->get();

            foreach ($reports as $report) {
                $this->destroy($report);
            }

            return true;
        });

        return true;
    }

}
