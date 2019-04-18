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
        }elseif($custom_search = $this->request->get('custom_search') ) {
            $custom_search = json_decode($custom_search);
            $date = $custom_search->date;
            $client = $custom_search->client_name;
            $invoice_status = $custom_search->invoice_status;

            $date = explode('to', $date);

            
            if(count($date) > 0) {
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

                if($client){
                    $this->query->where('client_name', 'LIKE', "%{$client}%");
                }

                if($invoice_status){
                    $this->query->where('invoice_status', '=', $invoice_status);
                }

            }

            if($client){
                $this->query->where('client_name', 'LIKE', "%{$client}%");
            }

            if($invoice_status){
                $this->query->where('invoice_status', '=', $invoice_status);
            }

            // if($)

        }
    }

    /**
     * @param $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function result($columns)
    {
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


        //For Custom search on statusReport
        if($custom_search = $this->request->get('custom_search') ) {
            $custom_search = json_decode($custom_search);
            $date = $custom_search->date;
            
            $jobcardstatus = $custom_search->jobcardstatus;
            $manager = $custom_search->manager;
            $technician = $custom_search->technician;
            $date = explode('to', $date);

            
            if(count($date) > 0) {
                

                      
                if($jobcardstatus){
                    $this->query->where('jobcard.status', 'LIKE', "%{$jobcardstatus}%");
                }

                if($manager){
                    $this->query->leftjoin('users', 'users.id', 'jobcard.projectmanager_id');
                    $this->query->leftjoin('role_user', 'role_user.user_id', 'users.id');
                    $this->query->where('users.name', $manager);
                    $this->query->where('role_user.role_id', '2');
                }


                if($technician){
                    $this->query->leftjoin('users', 'users.id', 'jobcard.contractor_id');
                    $this->query->leftjoin('role_user', 'role_user.user_id', 'users.id');
                    $this->query->where('users.name', $technician);
                    $this->query->where('role_user.role_id', '7');
                }

                // if($jobcardstatus) {
                //     $this->query->where('project_manager')
                // }
            }
        }

        //dd($user_role);
        // return response()->json(['hi' => !empty($user_role)]);
        if ($user_role > 1 || !empty($user_role)) {
            $result =  $this->query->Where('contractor_id', $user_id)->paginate($this->request->get('perPage'), $columns);
            return $result;
        }else{
        //     $result = vsprintf(str_replace('?', '%s', $this->query->toSql()), collect($this->query->getBindings())->map(function ($binding) {
        //         return is_numeric($binding) ? $binding : "'{$binding}'";
        //     })->toArray());
        // dd($result);
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
