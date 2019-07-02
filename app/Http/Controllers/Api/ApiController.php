<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Jobcard;
use App\Models\Settings;
use App\Models\User;
use Hash;

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
}
