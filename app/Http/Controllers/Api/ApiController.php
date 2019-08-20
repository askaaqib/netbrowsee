<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Jobcard;
// use App\Models\JobcardTest as Jobcard;
use App\Models\Settings;
use App\Models\User;
use Hash;
use Image;

class ApiController extends Controller
{

    public function userAuthenticate(Request $request) {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            
            if(
                isset(auth()->user()->roles[0]->name) &&
                ( auth()->user()->roles[0]->name == 'Technician/SubContractor' ||
                  auth()->user()->roles[0]->name == 'Administrator'
                )
            ){
                return response()->json([
                    'status' => 200,
                    'response' => 'Succesfully Logged In',
                    'userId' => auth()->user()->id,
                    'role' => auth()->user()->roles[0]->name 
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'response' => 'Unable to login',
                    'role' => auth()->user()->roles[0]->name
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'response' => 'Credentials do not match'
            ]);
        }
    }


    public function getJobCards(Request $request, Jobcard $jobcard) {
        $user_id = (isset($request->user_id)) ? $request->user_id : 27;
        $search = (isset($request->search)) ? $request->search : null;
        // $page = (isset($request->page)) ? $request->page : null;
        // $per_page = (isset($request->per_page)) ? $request->per_page : null;

        // $offset = ($page * $per_page) - $per_page;
        // if(!isset($page) || !isset($per_page)) {
        //     return response()->json([
        //         'status' => 400,
        //         'response' => 'Parameters are Required'
        //     ]);
        // }

        if($search) {
            $jobcards = Jobcard::select('id', 'jobcard_num', 'problem_type', 'description', 'priority', 'facility_name', 'district', 'before_pictures', 'after_pictures', 'attachment_receipt','created_at', 'status','labour_paid', 'materials_paid', 'travelling_paid')->where('contractor_id', $user_id)->where(function($query) use ($search) {
                $query->where('jobcard_num', 'LIKE', '%'.$search.'%')
                    ->orWhere('priority', 'LIKE', '%'.$search.'%')
                    ->orWhere('description', 'LIKE', '%'.$search.'%')
                    ->orWhere('status', 'LIKE', '%'.$search.'%')
                    ->orWhere('facility_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('problem_type', 'LIKE', '%'.$search.'%')
                    ->orWhere('labour_paid', 'LIKE', '%'.$search.'%')
                    ->orWhere('materials_paid', 'LIKE', '%'.$search.'%')
                    ->orWhere('travelling_paid', 'LIKE', '%'.$search.'%');
            })->get();

        } else {
            $jobcards = $jobcard::select('id', 'jobcard_num', 'problem_type', 'description', 'priority', 'facility_name', 'district', 'before_pictures', 'after_pictures', 'attachment_receipt','created_at', 'status','labour_paid', 'materials_paid', 'travelling_paid')->where('contractor_id', $user_id)->get();   
            foreach($jobcards as $jobcard) {
                $jobcard->date = $jobcard->created_at->format('d/m/Y');
            }
        }
        
        if (count($jobcards) > 0) {
            foreach($jobcards as $jobcard) {
                $jobcard->date = $jobcard->created_at->format('d/m/Y');
            }
        }
            
        return $jobcards;
    }

    public function getAllJobCards(Request $request, Jobcard $jobcard) {
        $search = (isset($request->search)) ? $request->search : null;
        // $page = (isset($request->page)) ? $request->page : null;
        // $per_page = (isset($request->per_page)) ? $request->per_page : null;

        // $offset = ($page * $per_page) - $per_page;
        // if(!isset($page) || !isset($per_page)) {
        //     return response()->json([
        //         'status' => 400,
        //         'response' => 'Parameters are Required'
        //     ]);
        // }
        if($search) {
            $jobcards = Jobcard::select('id', 'jobcard_num', 'problem_type', 'description', 'priority', 'facility_name', 'district', 'before_pictures', 'after_pictures', 'attachment_receipt','created_at', 'status','labour_paid', 'materials_paid', 'travelling_paid')->where(function($query) use ($search) {
                $query->where('jobcard_num', 'LIKE', '%'.$search.'%')
                    ->orWhere('priority', 'LIKE', '%'.$search.'%')
                    ->orWhere('description', 'LIKE', '%'.$search.'%')
                    ->orWhere('status', 'LIKE', '%'.$search.'%')
                    ->orWhere('facility_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('problem_type', 'LIKE', '%'.$search.'%')
                    ->orWhere('labour_paid', 'LIKE', '%'.$search.'%')
                    ->orWhere('materials_paid', 'LIKE', '%'.$search.'%')
                    ->orWhere('travelling_paid', 'LIKE', '%'.$search.'%');
            })->get();

        } else {
            $jobcards = $jobcard::select('id', 'jobcard_num', 'problem_type', 'description', 'priority', 'facility_name', 'district', 'before_pictures', 'after_pictures', 'attachment_receipt','created_at', 'status','labour_paid', 'materials_paid', 'travelling_paid')->get();   
            foreach($jobcards as $jobcard) {
                $jobcard->date = $jobcard->created_at->format('d/m/Y');
            }
        }
        if (count($jobcards) > 0) {
            foreach($jobcards as $jobcard) {
                $jobcard->date = $jobcard->created_at->format('d/m/Y');
            }
        }
            
        return $jobcards;
    }

    public function getSettingsInfo(Settings $setting) {
        $data = $setting::select('company_name', 'company_address', 'company_logo')->first();

        return $data;
    }

    public function getUserInfo(Request $request, User $user) {
        $user_id = $request->user_id;
        $data = $user::select('name', 'email')->where('id', $user_id)->first();

        return $data;
    }

    public function updateUserInfo(Request $request, User $user) {
        $user_id = $request->user_id;
        $name = $request->name;
        $email = $request->email;
        $update_arr = [
            'name' => $name,
            'email' => $email
        ];
        if(isset($request->old_password)) {
            $old_password = $request->old_password;
            $new_password = Hash::make($request->new_password);
            // $new_password = Hash::make('secret1122');
            if(Auth::attempt(['email' => $email, 'password' => $old_password])){
                $update_arrr = [
                    'password' => $new_password
                ];
                $update1 = $user::where('id', $user_id)->update($update_arrr);
                if (!$update1) {
                    return response()->json([
                        'status' => 300,
                        'response' => 'Unable to update password'
                    ]);    
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'response' => 'Credentials do not match'
                ]);
            }
            // $user::where('id', $user_id)->where()
        }
        $update = $user::where('id', $user_id)->update($update_arr);

        if ($update) {
            return response()->json([
                'status' => 200,
                'response' => 'User updated successfully'
            ]);
        }
        return response()->json([
            'status' => 200
        ]);
    }

    public function getJobcard(Request $request, Jobcard $jobcard) {
        $id = $request->id;
        $data = $jobcard::select('id', 'jobcard_num', 'problem_type','description', 'priority', 'facility_name', 'district', 'before_pictures', 'after_pictures', 'attachment_receipt','created_at', 'status','labour_paid', 'materials_paid', 'travelling_paid')->where('id', $id)->first();
        
        return $data;
    }

    public function uploadJobcardPhoto(Request $request, Jobcard $jobcard, User $user_model) {
        if ($request->hasFile('images')) {
            $jobcard_id = $request->jobcard_id;
            $type = $request->type;

            $jobcard_data = $jobcard::where('id', $jobcard_id)->select('before_pictures', 'after_pictures', 'attachment_receipt')->first();

            /******** STORE AND SAVE IMAGES TO DATABASE ********/
            $type_json= array();
            $images = $request->file('images');
            if ($type === 'before_pictures') {
                $decode_arr = json_decode($jobcard_data->before_pictures, true);
            }
            if ($type === 'after_pictures') {
                $decode_arr = json_decode($jobcard_data->after_pictures, true);
            }
            if ($type === 'attachment_receipt') {
                $decode_arr = json_decode($jobcard_data->attachment_receipt, true);
            }
            foreach($images as $image) {
                $cleanImageName = $user_model->cleanImageName($image->getClientOriginalName());

                $imageName = rand(0,10000000).$cleanImageName;
                $moved = $image->move(base_path('/public/images/jobcard/'), 'MobileUpload'.$imageName);
                if(!$moved) {
                    return response()->json([
                        'response' => 'Unable to upload file'
                    ]);
                } 
                if ($type === 'before_pictures') {
                    $decode_arr[]['image_name'] = '/images/jobcard/'. 'MobileUpload'.$imageName;
                }
                if ($type === 'after_pictures') {
                    $decode_arr[]['image_name'] = '/images/jobcard/'. 'MobileUpload'.$imageName;
                }
                if ($type === 'attachment_receipt') {
                    $decode_arr[]['image_name'] = '/images/jobcard/'. 'MobileUpload'.$imageName;
                    // $type_json = json_encode($decode_arr);
                }
            }

            $update_arr = [
              $type => json_encode($decode_arr)
            ];
            
            $update_json = $jobcard::where('id', $jobcard_id)->update($update_arr);

            if ($update_json) {
                return response()->json([
                    'status' => true,
                    'message' => 'Uploaded successfully'
                ]);                
            } else {
                return response()->json([
                    'message' => 'Unable to update json'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'response' => 'No Uploaded Files Found'
            ]);
        }
    }

    public function deleteJobcardPic(Request $request, Jobcard $jobcard){
        $data = $request->all();
        $jobcard_id = $request->id;
        $type = $request->type;
        $image_name = $request->image_name;

        $jobcard_data = $jobcard::where('id', $jobcard_id)->select('before_pictures', 'after_pictures', 'attachment_receipt')->first();

        if ($type === 'before_pictures') {
            $decode_arr = json_decode($jobcard_data->before_pictures, true);
        }
        if ($type === 'after_pictures') {
            $decode_arr = json_decode($jobcard_data->after_pictures, true);
        }
        if ($type === 'attachment_receipt') {
            $decode_arr = json_decode($jobcard_data->attachment_receipt, true);
        }
        $old_array = $decode_arr;
        /* REMOVE IMAGE NAME FROM THE ARRAY*/
        foreach($decode_arr as $key => $entry) {
            $found = false;
            if($entry['image_name'] == $image_name) {
                $found = true;
                unset($decode_arr[$key]);
                break;
            }
        }
        if ($found) {
            if(file_exists(public_path().$image_name)) {
              unlink(public_path().$image_name);
            }
        }

        $update_arr = [
          $type => json_encode(array_values($decode_arr))
        ];
        // $json_out = json_encode(array_values($your_array_here));    
        $update_json = $jobcard::where('id', $jobcard_id)->update($update_arr);
        
        if ($update_json) {
            return response()->json([
                'status' => true,
                'message' => 'Deleted successfully'
            ]);                
        } else {
            return response()->json([
                'message' => 'Unable to update json'
            ]);
        }
    }

    public function updateJobcard(Request $request, Jobcard $jobcard) {
        $data = $request->postdata;
        $jobcard_id = $data["id"];
        
        // $update_arr = [
        //   'jobcard_num' => $data["jobcard_num"], 
        //   'description' => $data["description"], 
        //   'facility_name' => $data["facility_name"], 
        //   'priority' => $data["priority"],
        //   'status' => $data["status"]
        // ];
        $update_arr = $data;
        unset($update_arr['id']);
        $update = $jobcard::where('id', $jobcard_id)->update($update_arr);
        if ($update) {
            return response()->json([
                'status' => true,
                'response' => $data
            ]);
        } else {
            return response()->json([
                'message' => 'Unable to update'
            ]);
        }
    }

    public function saveOfflineImages(Request $request, Jobcard $jobcard, User $user_model) {
        // $data = json_decode($request->data, true);
        $images = $request->file('images');
        $filename = 'initialized';
        $before_pictures_new = array();
        $after_pictures_new = array();
        $attachment_receipt_new = array();
        foreach($images as $id => $data) {
            $jobcard_id = $id;
            $jobcard_data = $jobcard::where('id', $jobcard_id)->select('before_pictures', 'after_pictures', 'attachment_receipt')->first();

            $decode_before = json_decode($jobcard_data->before_pictures, true);
            $decode_after = json_decode($jobcard_data->after_pictures, true);
            $decode_attachment = json_decode($jobcard_data->attachment_receipt, true);

            foreach($data as $type => $imageData) {
                foreach($imageData as $imgg) {
                    $cleanImageName = $user_model->cleanImageName($imgg->getClientOriginalName());

                    $imageName = rand(0,10000000).$cleanImageName;
                    $moved = $imgg->move(base_path('/public/images/jobcard/'), 'NewMobileUpload'.$imageName);
                    
                    if($moved) {
                        if($type == 'before_pictures') {
                            $decode_before[]['image_name'] = '/images/jobcard/'. 'NewMobileUpload'.$imageName;
                        }
                        if($type == 'after_pictures') {
                            $decode_after[]['image_name'] = '/images/jobcard/'. 'NewMobileUpload'.$imageName;
                        }
                        if($type == 'attachment_receipt') {
                            $decode_attachment[]['image_name'] = '/images/jobcard/'. 'NewMobileUpload'.$imageName;
                        }
                    } 
                }
            }
             
            $encode_before = (count($decode_before) > 0) ? json_encode($decode_before) : '[]'; 
            $encode_after = (count($decode_after) > 0) ? json_encode($decode_after) : '[]'; 
            $encode_attachment = (count($decode_attachment) > 0) ? json_encode($decode_attachment) : '[]'; 
            
            $update_arr = [
              'before_pictures' => $encode_before,
              'after_pictures' => $encode_after,
              'attachment_receipt' => $encode_attachment
            ];

            $update_json = $jobcard::where('id', $jobcard_id)->update($update_arr);
            
            if(!$update_json) {
                return response()->json([
                    'status' => true,
                    'response' => 'Unable to update data'
                ]);
            }
        }
        
        return response()->json([
            'status' => true,
            'response' => 'Successfully Uploaded Images'
        ]);        
    }

    public function saveOfflineJobcards(Request $request, Jobcard $jobcard) {
        $data = $request->data;
        $decode_data = json_decode($data, true);
        
        foreach($decode_data as $data1) {
            $update_arr = [
                'jobcard_num' => $data1['data']['jobcard_num'],
                'description' => $data1['data']['description'],
                'facility_name' => $data1['data']['facility_name'],
                'priority' => $data1['data']['priority'],
                'labour_paid' => $data1['data']['labour_paid'],
                'travelling_paid' => $data1['data']['travelling_paid'],
                'materials_paid' => $data1['data']['materials_paid']
            ];
            unset($data1['data']['id']);
            $update = $jobcard::where('id', $data1['id'])->update($update_arr);
            if(!$update) {
                return response()->json([
                    'status' => true,
                    'response' => $data1['data']
                ]);
            }
        }
        return response()->json([
            'status' => true,
            'response' => 'Successfully Updated Everything'
        ]);
    }
}
