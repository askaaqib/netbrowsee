<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\TagRepository;
use App\Repositories\Contracts\LabourRateRepository;
use App\Repositories\Contracts\MaterialRateRepository;
use App\Repositories\Contracts\VatRepository;
use App\Repositories\Contracts\SettingsRepository;
use App\Repositories\Contracts\ProjectRepository;
use App\Repositories\Contracts\ProjectManagerRepository;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\QuotesRepository;
use App\Repositories\Contracts\JobcardRepository;
use Mcamara\LaravelLocalization\LaravelLocalization;
use App\Repositories\Contracts\DistrictRepository;
use App\Repositories\Contracts\SubDistrictRepository;

use App\Models\Jobcard;
use App\Models\Settings;
use App\Models\Quotes;
use App\Models\Invoices;
use App\Models\User;

class AjaxController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $posts;

    /**
     * @var TagRepository
     */
    protected $tags;

    /**
     * @var LaravelLocalization
     */
    protected $localization;

    /**
     * AjaxController constructor.
     *
     * @param \App\Repositories\Contracts\PostRepository       $posts
     * @param TagRepository                                    $tags
     * @param \Mcamara\LaravelLocalization\LaravelLocalization $localization
     */
    public function __construct(PostRepository $posts, TagRepository $tags, LaravelLocalization $localization)
    {
        $this->posts = $posts;
        $this->tags = $tags;
        $this->localization = $localization;
    }

    /**
     * Global index search.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        return empty($query) ? [] : $this->posts->search($query)->take(50)->get();
    }

    /**
     * Search internal transatables routes.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function routesSearch(Request $request)
    {
        $items = [];

        $routes = __('routes');

        foreach ($routes as $name => $uri) {
            $items[$name] = $uri;
        }

        return [
            'items' => $items,
        ];
    }

    /**
     * Search tags.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function tagsSearch(Request $request)
    {
        $query = $request->get('q');

        $locale = app()->getLocale();

        return [
            'items' => $this->tags->query()
                ->where("name->{$locale}", 'like', "%$query%")
                ->pluck('name'),
        ];
    }

    /**
     * Search labour.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getLabourRates(LabourRateRepository $labour)
    {

        return [
            'ids' => $labour->query()
                ->where('id' ,'>' ,0)
                ->pluck('rate')
        ];
    }

    /**
     * Search material.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getMaterialRates(MaterialRateRepository $material)
    {

        return [
            'ids' => $material->query()
                ->where('id' ,'>' ,0)
                ->pluck('rate')
        ];
    }

    /**
     * Search vat.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getVatRates(VatRepository $vat)
    {

        return [
            'ids' => $vat->query()
                ->where('id' ,'>' ,0)
                ->pluck('rate')
        ];
    }

    /**
     * Search Project.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getProjects(ProjectRepository $project)
    {

        return $project->query()
                ->where('id' ,'>' ,0)
                ->select('id','name')->get();
        
    }
    public function getProjectManager(ProjectManagerRepository $project_manager)
    {
        return $project_manager->query()
                 ->where('id' , '>' ,0)
                 ->select('id','name')->get();
    }
    public function getDistricts(DistrictRepository $district){

        return $district->query()
                    ->where('id','>',0) ->
                    select('id','name')->get();
    }


    public function getSubDistricts(SubDistrictRepository $subdistrict){

        return $subdistrict->query()
        ->where('id','>',0)->
        select('id','name')->get();
    }

    public function searchQuotes(QuotesRepository $quote, Request $request){
        $search = $request->get('q');
        if ($search) {
            return $quote->query()
                ->where('quotation_name' ,'LIKE' ,'%'. $search .'%')
                ->orWhere('quotation_digit' ,'LIKE' ,'%'. $search .'%')
                ->orWhere('quotation_number' ,'LIKE' ,'%'. $search .'%')
                ->orWhere('client_email' ,'LIKE' ,'%'. $search .'%')
                ->get();
        } else {
            return $quote->query()
                ->where('id' ,'>' ,0)
                ->get();    
        }
    }

    public function searchLabours(LabourRateRepository $labour, Request $request){
        $search = $request->get('q');
        if ($search) {
            return $labour->query()
                ->where('name' ,'LIKE' ,'%'. $search .'%')
                ->orWhere('rate' ,'LIKE' ,'%'. $search .'%')
                ->get();
        } else {
            return $labour->query()
                ->where('id' ,'>' ,0)
                ->get();    
        }
    }

    public function searchClients(UserRepository $user, Request $request){
        $search = $request->get('q');
        if ($search) {
            return $users = User::whereHas('roles', function($q){
                $q->where('name', 'redactor');
            })
            ->where('name','LIKE', '%'. $search . '%')
            ->orwhere('email','LIKE', '%'. $search . '%')
            ->get();
        } else {
            return $users = User::whereHas('roles', function($q){
                $q->where('name', 'redactor');
            })
            ->select('id','name','email')
            ->get();  
        }
    }

    public function getLabours(LabourRateRepository $labour)
    {
        return $labour->query()
        ->where('id' ,'>' ,0)
        ->select('id','name')->get();    
    }


    public function getMaterials(MaterialRateRepository $material)
    {

        return $material->query()
                ->where('id' ,'>' ,0)
                ->select('id','name')->get();
        
    }

    public function getUsers(UserRepository $user)
    {

        return $user->query()
                ->where('id' ,'>' ,0)
                ->select('id','name')->get();
        
    }

    public function getQuotations(QuotesRepository $quotes)
    {

        return $quotes->query()
                ->where('id' ,'>' ,0)
                ->select('id','quotation_name')->get();
        
    }

    public function getJobcards(JobcardRepository $jobcard, Request $request)
    {
        $jobcard_id = $request->get('id');
        if($jobcard_id){
            return $jobcard->query()
                ->where('id' , $jobcard_id)
                ->select('id','jobcard_num','facility_name')->get();
        }else{
            return $jobcard->query()
                ->select('jobcard_num','id')->get();  
        }
        
        
    }

    public function getVats(VatRepository $vat)
    {

        return $vat->query()
                ->where('id' ,'>' ,0)
                ->select('id','name')->get();
        
    }

    public function getProjectManagers(ProjectManagerRepository $project_manager, Request $request)
    {
        $project_id = $request->get('id');
        if($project_id){
            return $project_manager->query()
                ->where('project_id' , $project_id)
                ->select('id','name')->get();
        }
        else{
            return $project_manager->query()
                ->select('id','name')->get();
        }
    }

    public function getSettingsData()
    {
        $settings = Settings::orderBy('id', 'DESC')->first();    
        return $settings;
       
    }

    public function getQuotationsRecentReference()
    {
        $quote = Quotes::orderBy('id', 'DESC')->first();       
        return $quote;
       
    }

    public function getInvoicesRecentReference()
    {
        $invoice = Invoices::orderBy('id', 'DESC')->first();       
        return $invoice;
       
    }
    /**
     * @param Request $request
     *
     * @return array
     */
    public function imageUpload(Request $request)
    {
        $uploadedImage = $request->file('upload');

        // Resize image below 600px width if needed
        $image = Image::make($uploadedImage->openFile())->widen(600, function ($constraint) {
            $constraint->upsize();
        });

        $imagePath = "/tmp/{$uploadedImage->getClientOriginalName()}";
        Storage::disk('public')->put($imagePath, $image->stream());

        return [
            'uploaded' => true,
            'url'      => "/storage{$imagePath}",
            'width'    => $image->width(),
            'height'   => $image->height(),
        ];
    }

    public function JobcardRemoveImage(Request $request, Jobcard $jobcard_model, JobcardRepository $jobcard) {
      $id = $request->id;
      $image_name = $request->image_name;
      $type = $request->type;
      // dd($image_name);
      $result = $jobcard->query()->where('id', $id)->select('*')->get();
      if ($type == 'before_pictures') {
        $before_pictures = json_decode($result[0]->before_pictures, true);
          foreach($before_pictures as $key => $value) {
            if ($value['image_name'] == $image_name) {
              array_splice($before_pictures, $key, 1);
            }
          }
          $update_jobcard = [
            'before_pictures' => json_encode($before_pictures)
          ];
          $before_pictures = json_encode($before_pictures);
          $save = $jobcard_model::where('id', $id)->update($update_jobcard);
          if ($save) {
            if(file_exists(public_path().$image_name)) {
              if(unlink(public_path().$image_name)){
                return response()->json([
                  'status'  => 200,
                  'image_delete' => $image_name
                ]); 
              } else {
                return response()->json([
                  'status'  => 403
                ]); 
              }
            }
          }
      }
      if ($type == 'after_pictures')  {
        $after_pictures = json_decode($result[0]->after_pictures, true);
        foreach($after_pictures as $key => $value) {
            if ($value['image_name'] == $image_name) {
              array_splice($after_pictures, $key, 1);
            }
        }
        $update_jobcard = ['after_pictures' => json_encode($after_pictures)];
        $after_pictures = json_encode($after_pictures);
        $save = $jobcard_model::where('id', $id)->update($update_jobcard);
        if ($save) {
            if(file_exists(public_path().$image_name)) {
                if(unlink(public_path().$image_name)){
                return response()->json([
                  'status'  => 200,
                  'image_delete' => $image_name
                ]); 
              } else {
                return response()->json([
                  'status'  => 403
                ]); 
              }
            }
        }
      }
      if ($type == 'attachment_receipt')  {
        $attachment_receipt = json_decode($result[0]->attachment_receipt, true);
        foreach($attachment_receipt as $key => $value) {
            if ($value['image_name'] == $image_name) {
              array_splice($attachment_receipt, $key, 1);
            }
        }
        $update_jobcard = ['attachment_receipt' => json_encode($attachment_receipt)];
        $attachment_receipt = json_encode($attachment_receipt);
        $save = $jobcard_model::where('id', $id)->update($update_jobcard);
        if ($save) {
            if(file_exists(public_path().$image_name)) {
                if(unlink(public_path().$image_name)){
                return response()->json([
                  'status'  => 200,
                  'image_delete' => $image_name
                ]); 
              } else {
                return response()->json([
                  'status'  => 403
                ]); 
              }
            }
        }
      }
    }     
}
