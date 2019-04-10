<?php

namespace App\Utils;

use Illuminate\Http\Request;
use App\Exports\DataTableExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RequestSearchQuery
{
    /**
     * @var \Request
     */
    private $request;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $query;

    public function __construct(Request $request, Builder $query, $searchables = [])
    {
        $this->request = $request;
        $this->query = $query;

        $this->initializeQuery($searchables);
    }

    private function getLocalizedColumn(Model $model, $column)
    {
        if (property_exists($model, 'translatable') && \in_array($column, $model->translatable, true)) {
            $locale = app()->getLocale();

            return "$column->$locale";
        }

        return $column;
    }

    /**
     * @param array $searchables
     */
    public function initializeQuery($searchables = [])
    {
        $model = $this->query->getModel();

        if ($column = $this->request->get('column')) {
            $this->query->orderBy(
                $this->getLocalizedColumn($model, $column),
                $this->request->get('direction') ?? 'asc'
            );
        }
        if ($search = $this->request->get('search')) {
            $this->query->where(function (Builder $query) use ($model, $searchables, $search) {
                foreach ($searchables as $key => $searchableColumn) {
                    $query->orWhere(
                        $this->getLocalizedColumn($model, $searchableColumn), 'like', "%{$search}%"
                    );
                }
            });
        }elseif($date = $this->request->get('date')) {
            $date = explode('to', $date);
            // dd($date);
            $this->query->where(function (Builder $query) use ($model, $searchables, $date) {

                foreach ($searchables as $key => $searchableColumn) {
                    if($searchableColumn == 'invoices.created_at'
                    || $searchableColumn == 'jobcard.created_at'){
                        if($date[0]){
                            $query->Where(
                                $this->getLocalizedColumn($model, $searchableColumn), '>=', "{$date[0]}"
                            );
                        }
                        if( isset($date[1]) ){
                            $stop_date = date('Y-m-d', strtotime($date[1] . ' +1 day'));
                            $query->Where(
                                $this->getLocalizedColumn($model, $searchableColumn), '<=', "{$stop_date}"
                            );
                        }
                    }
                }
            });
        }
    }

    /**
     * @param $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function result($columns)
    {
        dd($this->query->toSql());
        $result = $this->query->paginate($this->request->get('perPage'), $columns);
        return $result;
    }

    public function resultJobcard($columns)
    {

        $model = $this->query->getModel();
        $user_id = auth()->user()->id;
        //dd($user_id);
        $role = auth()->user()->roles;
        //dd($role);
        $user_role = isset($role[0]->id ) ? $role[0]->id : '';

        //dd($user_role);
        // return response()->json(['hi' => !empty($user_role)]);
        if ($user_role > 1 || !empty($user_role)) {
            $result =  $this->query->Where('contractor_id', $user_id)->paginate($this->request->get('perPage'), $columns);
            return $result;
        }else{
            $result = $this->query->paginate($this->request->get('perPage'), $columns);
            // return response()->json(['hi' => $result]);
            return $result;
        }
}

    /**
     * @param       $columns
     * @param array $headings
     * @param       $fileName
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($columns, $headings, $fileName)
    {
        $currentDate = date('dmY-His');

        return Excel::download(
            new DataTableExport($headings, $this->query, $columns),
            "$fileName-export-$currentDate.xlsx"
        );
    }
}
