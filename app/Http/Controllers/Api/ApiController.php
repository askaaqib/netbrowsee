<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
// use App\Models\Jobcard;
use App\Models\JobcardTest as Jobcard;
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


        $data = $request->all();
      return response()->json([
            'status' => true,
            'response' => $data
        ]);
        $images = $data['uploadimagetmp'];
        $images = json_decode($images, true);
        $datee = date("Y-m-d",time());
        $new_images = array();
        foreach($images as $img) {
            $png_url = "MobileUpload-".$datee."-".rand(100,100000).".png";
            $path = base_path('/public/images/jobcard/'). $png_url;
            // $img['data'] = str_replace(' ', '+', $img['data']);

            // $saved = Image::make($img['path'])->save($path);
            // if ($saved) {
            //     array_push($new_images, ['image_name' => $png_url]);
            // }
        }
             
  

        if ($request->hasFile('uploadimagetmp')) {
            $jobcard_id = $request->jobcard_id;
            $type = $request->type;

            $jobcard_data = $jobcard::where('id', $jobcard_id)->select('before_pictures', 'after_pictures', 'attachment_receipt')->first();
            
            $image = $request->file('uploadimagetmp');

            $cleanImageName = $user_model->cleanImageName($image->getClientOriginalName());

            $imageName = rand(0,10000000).$cleanImageName;
            $uploaded = $image->move(base_path('/public/images/jobcard/'), $imageName);
            $type_json = [];
            if ($type === 'before_pictures') {
                $decode_arr = json_decode($jobcard_data->before_pictures, true);
                $decode_arr[]['image_name'] = '/images/jobcard/'. $imageName;
                $type_json = json_encode($decode_arr);
            }
            if ($type === 'after_pictures') {
                $decode_arr = json_decode($jobcard_data->after_pictures, true);
                $decode_arr[]['image_name'] = '/images/jobcard/'. $imageName;
                $type_json = json_encode($decode_arr);
            }
            if ($type === 'attachment_receipt') {
                $decode_arr = json_decode($jobcard_data->attachment_receipt, true);
                $decode_arr[]['image_name'] = '/images/jobcard/'. $imageName;
                $type_json = json_encode($decode_arr);
            }
            
            // $imageNames[]['image_name'] = '/images/jobcard/'.$imageName;

            // $name = $file->getClientOriginalName();
            // $data[ 'uploadimagetmp' ] = $name;

            // $request->file('uploadimagetmp')->move(base_path('/public/images/jobcard/'), 'MobileUpload-' .$name);
            // $uploaded = $image->move(base_path('/public/images/jobcard/'),$imageName);
            if ($uploaded) {
                $update_arr = [
                  $type => $type_json
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
                    'message' => 'Unable to upload'
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Nothing found'
            ]);
        }
    }
}
