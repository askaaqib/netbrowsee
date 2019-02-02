<?php

namespace App\Repositories;

use App\Models\Invoices;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\InvoicesRepository;

/**
 * Class EloquentInvoicesRepository.
 */
class EloquentInvoicesRepository extends EloquentBaseRepository implements InvoicesRepository
{
    /**
     * EloquentUserRepository constructor.
     *
     * @param Invoices $invoice
     */
    public function __construct(
        Invoices $invoices
    ) {
        parent::__construct($invoices);
    }

    /**
     * @param Invoices                               $invoice
     * @param array                              $input
     * @param \Illuminate\Http\UploadedFile|null $image
     *
     * @throws \App\Exceptions\GeneralException|\Exception|\Throwable
     *
     * @return mixed
     */
    public function save(Invoices $invoice, array $input)
    {
        //dd($invoice,$input);
        DB::transaction(function () use ($invoice, $input) {
            if (! $invoice->save()) {
                throw new GeneralException(__('exceptions.backend.invoices.save'));
            }           
            return true;
        });

        return true;
    }

    /**
     * @param Invoices $invoice
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroy(Invoices $invoice)
    {
        if (! $invoice->delete()) {
            throw new GeneralException(__('exceptions.backend.invoices.delete'));
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

            /** @var Invoices[] $projects */
            $invoices = $query->get();

            foreach ($invoices as $invoice) {
                $this->destroy($invoice);
            }

            return true;
        });

        return true;
    }

}
