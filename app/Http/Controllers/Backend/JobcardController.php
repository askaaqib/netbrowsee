<?php

namespace App\Http\Controllers\Backend;

use App\Models\Jobcard;
use Illuminate\Http\Request;
use App\Utils\RequestSearchQuery;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreJobcardRequest;
use App\Http\Requests\UpdateJobcardRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\JobcardRepository;
use Mail;
use DB;

class JobcardController extends BackendController
{
    /**
     * @var JobcardRepository
     */
    protected $jobcard;

    /**
     * Create a new controller instance.
     *
     *
     * @param \App\Repositories\Contracts\JobcardRepository $jobcard
     */
    public function __construct(JobcardRepository $jobcard)
    {
        //dd($jobcards);
        $this->jobcard = $jobcard;
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function search(Request $request)
    {

        /** @var Builder $query */
        $query = $this->jobcard->query();

        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'jobcard_num',
            'description',
            'problem_type',
            'priority',
            'facility_name',
            'district',
            'sub_district',
            'travelling_paid',
            'status',
        ]);

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'jobcard_num',
                'description',
                'problem_type',
                'priority',
                'facility_name',
                'district',
                'sub_district',
                'travelling_paid',
               // 'quoted_amount',
                'status',
                'jobcard.created_at',
                'jobcard.updated_at',
            ],
                [
                    __('validation.jobcards.jobcard_num'),
                    __('validation.jobcards.description'),
                    __('validation.jobcards.problem_type'),
                    __('validation.jobcards.priority'),
                    __('validation.jobcards.facility_name'),
                    __('validation.jobcards.district'),
                    __('validation.jobcards.sub_district'),
                    __('validation.jobcards.travelling_paid'),
                  // __('validation.jobcards.quoted_amount'),
                    __('validation.jobcards.status'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'jobcard');
        }

        return $requestSearchQuery->resultJobcard([
            'jobcard.id',
            'jobcard_num',
            'description',
            'problem_type',
            'priority',
            'status',
            'facility_name',
            'district',
            'sub_district',
            //'quoted_amount',
            'jobcard.created_at',
            'jobcard.updated_at',
        ]);
    }

     public function statusreport(Request $request)
    {

        /** @var Builder $query */
        $query = $this->jobcard->query();
        $requestSearchQuery = new RequestSearchQuery($request, $query, [
            'status',
        ]);

        return $requestSearchQuery->resultJobcard([
            'jobcard.id',
            'jobcard_num',
            'description',
            'problem_type',
            'priority',
            'status',
            'facility_name',
            'district',
            'sub_district',
            'projectmanager_id',
            'contractor_id',
            //'quoted_amount',
            'jobcard.created_at',
            'jobcard.updated_at',
        ]);
    }

    public function jobcardreports(Request $request) {
        /** @var Builder $query */
        $query = $this->jobcard->query();
        $model = $query->getModel();

        if(isset($request->item_id)) {
            $query->where('item_id', $request->item_id);
        }

        $searchables = [
            'status',
        ];

        if ($request->get('exportData')) {
            return $requestSearchQuery->export([
                'color',
                'size',
                'jobcard.created_at',
                'jobcard.updated_at',
            ],
                [
                    __('validation.jobcard.description'),
                    __('validation.jobcard.color'),
                    __('validation.jobcard.size'),
                    __('labels.created_at'),
                    __('labels.updated_at'),
                ],
                'jobcard');
        }
        if ($search = $request->get('search')) {
            $query->where(function (Builder $query) use ($model, $searchables, $search) {
                foreach ($searchables as $key => $searchableColumn) {
                    $query->orWhere(
                        $this->getLocalizedColumn($model, $searchableColumn), 'like', "%{$search}%"
                    );
                }
            });
        }
        $columns = [
            'jobcard.id',
            'jobcard_num',
            'labour_paid',
            'materials_paid',
            'travelling_paid',
            'quote_id',
            'quote_amount',
            'status',
            'jobcard.created_at',
            'jobcard.updated_at',
        ];
        $result = $query->select(
                'id', 'jobcard_num', 'labour_paid',
                'materials_paid', 'travelling_paid',
                'quote_id', 'quote_amount', 'status',
                DB::raw('(labour_paid + materials_paid + travelling_paid) as expenses'))
                ->paginate($request->get('perPage'), $columns);
        return $result;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param StoreJobcardRequest $request
     *
     * @return mixed
     */
    public function store(StoreJobcardRequest $request)
    {

       //  $data = $request->all();
       // // dd($data);
       //  // $data['projects_id'] = $request->projects_id['id'];
       //  // $data['labour_rates_id'] = $request->labour_rates_id['id'];
       //  // $data['materials_rates_id'] = $request->materials_rates_id['id'];
       //  // $data['contractor_id'] = $request->contractor_id['id'];
       //  // $data['quotations_id'] = $request->quotations_id['id'];

       //  //dd($data);
       //  $jobcard = $this->jobcard->make($data);

       //  if ('publish' === $data['status']) {
       //      $this->jobcard->saveAndPublish($jobcard, $data);
       //  } else {
       //      $this->jobcard->saveAsDraft($jobcard, $data);
       //  }

       //  return $this->redirectResponse($request, __('alerts.backend.jobcards.created'));

       $data = $request->all();

        if(isset($data['before_pictures'])) {
            $imageNames = array();
            $images = $data['before_pictures'];
            foreach($images as $image) {
                $imageName = rand(0,10000000).$image->getClientOriginalName();
                $uploaded = $image->move(base_path('/public/images/jobcard/'),$imageName);
                $imageNames[]['image_name'] = '/images/jobcard/'.$imageName;
            }
            $data['before_pictures'] = json_encode($imageNames);
        }
         if(isset($data['after_pictures'])) {
            $imageNames = array();
            $images = $data['after_pictures'];
            foreach($images as $image) {
                $imageName = rand(0,10000000).$image->getClientOriginalName();
                $uploaded = $image->move(base_path('/public/images/jobcard/'),$imageName);
                $imageNames[]['image_name'] = '/images/jobcard/'.$imageName;
            }
            $data['after_pictures'] = json_encode($imageNames);
        }
        if(isset($data['attachment_receipt'])) {
            $imageNames = array();
            $images = $data['attachment_receipt'];
            foreach($images as $image) {
                $imageName = rand(0,10000000).$image->getClientOriginalName();
                $uploaded = $image->move(base_path('/public/images/jobcard/'),$imageName);
                $imageNames[]['image_name'] = '/images/jobcard/'.$imageName;
            }
            $data['attachment_receipt'] = json_encode($imageNames);
        }
        // dd($data);
        $jobcard = $this->jobcard->make($data);

        if ('publish' === $data['status']) {
            $this->jobcard->saveAndPublish($jobcard, $data);
        } else {
            $this->jobcard->saveAsDraft($jobcard, $data);
        }
        return $this->redirectResponse($request, __('alerts.backend.jobcards.created'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getLastestJobcards()
    {
        $query = $this->jobcard->query();

        return $query->orderByDesc('created_at')->limit(10)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function show(Jobcard $jobcard)
    {
        return $jobcard;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobcard $jobcard)
    {
        //
    }

     /**
     * @param Jobcard              $jobcard
     * @param UpdateJobcardRequest $request
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     *
     * @return mixed
     */
    public function update(Jobcard $jobcard, UpdateJobcardRequest $request)
    {
        $data = $request->all();
        $old_status = $jobcard->status;
        $new_status = $data['status'];
        /************* BEFORE PICTURES *************/
        if(isset($data['before_pictures']) && !isset($data['before_pictures_edit'])) {
            $data['before_pictures'] = json_encode($data['before_pictures']);
        }

        if(isset($data['before_pictures']) && isset($data['before_pictures_edit'])) {
            $imageNamesBefore = array();
            /* loop old data and add to new array */
            $old_images_before = $data['before_pictures'];
            foreach($old_images_before as $image) {
                $imageNamesBefore[]['image_name'] = $image['image_name'];
            }
        }
        if (isset($data['before_pictures_edit'])) {
            $new_images_before = $data['before_pictures_edit'];
            foreach($new_images_before as $image) {
                $imageNameBefore = rand(0,10000000).$image->getClientOriginalName();
                $uploadedBefore = $image->move(base_path('/public/images/jobcard/'),$imageNameBefore);
                $imageNamesBefore[]['image_name'] = '/images/jobcard/'.$imageNameBefore;
            }
            $data['before_pictures'] = json_encode($imageNamesBefore);
        }

        /************* AFTER  PICTURES *************/
        if(isset($data['after_pictures']) && !isset($data['after_pictures_edit'])) {
            $data['after_pictures'] = json_encode($data['after_pictures']);
        }

        if(isset($data['after_pictures']) && isset($data['after_pictures_edit'])) {
            $imageNamesAfter = array();
            /* loop old data and add to new array */
            $old_images_after = $data['after_pictures'];
            foreach($old_images_after as $image) {
                $imageNamesAfter[]['image_name'] = $image['image_name'];
            }
        }
        if (isset($data['after_pictures_edit'])) {
            $new_images_after = $data['after_pictures_edit'];
            foreach($new_images_after as $image) {
                $imageNameAfter = rand(0,10000000).$image->getClientOriginalName();
                $uploadedAfter = $image->move(base_path('/public/images/jobcard/'),$imageNameAfter);
                $imageNamesAfter[]['image_name'] = '/images/jobcard/'.$imageNameAfter;
            }
            $data['after_pictures'] = json_encode($imageNamesAfter);
        }

        /************* Attachment and receipt PICTURES *************/
        if(isset($data['attachment_receipt']) && !isset($data['attachment_receipt_edit'])) {
            $data['attachment_receipt'] = json_encode($data['attachment_receipt']);
        }

        if(isset($data['attachment_receipt']) && isset($data['attachment_receipt_edit'])) {
            $imageNamesAttachment = array();
            /* loop old data and add to new array */
            $old_images_attachment = $data['attachment_receipt'];
            foreach($old_images_attachment as $image) {
                $imageNamesAttachment[]['image_name'] = $image['image_name'];
            }
        }
        if (isset($data['attachment_receipt_edit'])) {
            $new_images = $data['attachment_receipt_edit'];
            foreach($new_images as $image) {
                $imageNameAttachment = rand(0,10000000).$image->getClientOriginalName();
                $uploaded = $image->move(base_path('/public/images/jobcard/'),$imageNameAttachment);
                $imageNamesAttachment[]['image_name'] = '/images/jobcard/'.$imageNameAttachment;
            }
            $data['attachment_receipt'] = json_encode($imageNamesAttachment);
        }

        $jobcard->fill(
            $data
        );

        $saved = $this->jobcard->saveAndPublish($jobcard, $data);

        if ($saved) {
            if ($old_status != $new_status) {
                $this->sendEmail($old_status, $data);
            }
        }
        return $this->redirectResponse($request, __('alerts.backend.jobcards.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobcard $jobcard, Request $request)
    {
        $this->jobcard->destroy($jobcard);

        return $this->redirectResponse($request, __('alerts.backend.jobcards.deleted'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function batchAction(Request $request)
    {
        $action = $request->get('action');
        $ids = $request->get('ids');

        switch ($action) {
            case 'destroy':
                    $this->jobcard->batchDestroy($ids);
                    return $this->redirectResponse($request, __('alerts.backend.jobcards.bulk_destroyed'));
                break;
        }

        return $this->redirectResponse($request, __('alerts.backend.actions.invalid'), 'error');
    }
    public function file(StoreJobcardRequest $request) {

       // $data = $request->all();
       // //dd($data);
       //  if(isset($data['before_pictures'])) {
       //      $imageNames = array();
       //      $images = $data['before_pictures'];
       //      foreach($images as $image) {
       //          $imageName = rand(0,10000000).$image->getClientOriginalName();
       //          $uploaded = $image->move(base_path('/public/images/jobcard/'),$imageName);
       //          $imageNames[]['image_name'] = '/images/jobcard/'.$imageName;
       //      }
       //      $data['before_pictures'] = json_encode($imageNames);
       //  }
       //   if(isset($data['after_pictures'])) {
       //      $imageNames = array();
       //      $images = $data['after_pictures'];
       //      foreach($images as $image) {
       //          $imageName = rand(0,10000000).$image->getClientOriginalName();
       //          $uploaded = $image->move(base_path('/public/images/jobcard/'),$imageName);
       //          $imageNames[]['image_name'] = '/images/jobcard/'.$imageName;
       //      }
       //      $data['after_pictures'] = json_encode($imageNames);
       //  }
       //  // dd($data);

       //  $jobcard = $this->jobcard->make($data);

       //  if ('publish' === $data['status']) {
       //      $this->jobcard->saveAndPublish($jobcard, $data);
       //  } else {
       //      $this->jobcard->saveAsDraft($jobcard, $data);
       //  }
       //  return $this->redirectResponse($request, __('alerts.backend.jobcards.created'));
    }

    public function addedfile() {}

    protected function sendEmail($old_status, $data) {
      $to_email = 'netbrowse@yopmail.com';
      $mail_data = array("old_status" => $old_status, "data" => $data);
       try{
        Mail::send('emails.mail', $mail_data, function($message) use ($to_email) {
          $message->to($to_email)
            ->subject('NetBrowse');
          $message->from('support@netbrowse.com','Netbrowse App Support');
        });
        }
        catch(Exception $e){}
    }

    private function getLocalizedColumn(Jobcard $model, $column)
    {
        if (property_exists($model, 'translatable') && \in_array($column, $model->translatable, true)) {
            $locale = app()->getLocale();

            return "$column->$locale";
        }

        return $column;
    }
}
