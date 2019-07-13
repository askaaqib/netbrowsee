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
            if(isset(auth()->user()->roles[0]->name) && auth()->user()->roles[0]->name == 'Technician/SubContractor'){
                return response()->json([
                    'status' => 200,
                    'response' => 'Succesfully Logged In',
                    'userId' => auth()->user()->id
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'response' => 'Unable to login'
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
        $jobcards = $jobcard::select('id', 'jobcard_num', 'description', 'priority', 'facility_name', 'district', 'projectmanager_id')->where('contractor_id', $user_id)->get();

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
        $data = $jobcard::select('id', 'jobcard_num', 'description', 'priority', 'facility_name', 'district', 'before_pictures', 'after_pictures', 'attachment_receipt')->where('id', $id)->first();

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
        
        $update_arr = [
          'jobcard_num' => $data["jobcard_num"], 
          'description' => $data["description"], 
          'facility_name' => $data["facility_name"], 
          'priority' => $data["priority"]
        ];
        
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
}
