<?php

namespace App\Http\Controllers\Api;

 use App\Http\Requests\Donor\UpdateDonorRequest;
  use App\Models\Donor;
 use Illuminate\Http\Request;
 use App\Http\Requests\Donor\{CreateDonorRequest , AuthenticateDonor  , ChangeDonorEmailRequest , ChangeDonorPasswordRequest , UpdateDonorPrefrencesRequest , UpdateNotificationPreferences};
use App\Models\DonorNotificationPreference;
use App\Models\NotificationPreference;
use App\Models\Token;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthDonorController extends Controller
{

    public function update (UpdateDonorRequest $request)
    {
        try {
            $donor = $request->user();
            $donor->update($request->validated());
            return response(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete(Request $request){
        try {
            $request->user()->delete();
            return response(null);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function retrieve(Request $request)
    {
        try {
            $donor = $request->user();
            return response()->json([
                'id' => $donor->id ,
                'name' => $donor->name ,
                'email' => $donor->email ,
                'phone' => $donor->phone ,
                'country_code' => $donor->country_code ,
                'currency' => $donor->currency ,
                'locale' => $donor->locale ,
                'theme_mode' => $donor->theme_mode ,
                'theme_color' => $donor->theme_color ,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function changePassword(ChangeDonorPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $donor = $request->user();
            $donor->password = Hash::make($data['new_password']);
            $donor->save();
            return response(null);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
  
    public function changeEmail(ChangeDonorEmailRequest $request)
    {
        try {
            $data = $request->validated();
            $donor = $request->user();
            $donor->email = $data['new_email'];
            $donor->save();
            return response(null);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function updatePreferences(UpdateDonorPrefrencesRequest $request){
        try {
            $donor = $request->user();
            $donor->update($request->validated());
            return response(null);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function logout(Request $request){
        try{
            Token::where('api_token' , $request->bearerToken())->delete();
            return response(null);
        }catch(\Exception $e){
         return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function listNotificationPreferences(Request $request){
        try{
           
            return response()->json($request->user()->notification_preferences);
        }catch(\Exception $e){
         return response()->json(['error' => $e->getMessage()]);
        }
    }
   
    public function updateNotificationPreferences(UpdateNotificationPreferences $request){
        try{
            $donor = $request->user();
            DonorNotificationPreference::where('donor_id' , $donor->id)->delete();
            foreach($request->validated()['preferences'] as $p){
                DonorNotificationPreference::create(['donor_id'=>$donor->id ,'preference_id'=>NotificationPreference::where('name' , $p)->firstOrFail()->id]);
            }
            return response(null);
        }catch(\Exception $e){
         return response()->json(['error' => $e->getMessage()]);
        }
    }
   
}
