<?php

namespace App\Http\Controllers\Api;

 use App\Http\Requests\Donor\UpdateDonorRequest;
  use App\Models\Donor;
 use Illuminate\Http\Request;
 use App\Http\Requests\Donor\{CreateDonorRequest , AuthenticateDonor  , ChangeDonorEmail , ChangeDonorPassword , UpdateDonorPrefrences};
use App\Models\Token;
use Illuminate\Support\Facades\Hash;
use Exception;

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
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
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
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function changePassword(ChangeDonorPassword $request)
    {
        try {
            $data = $request->validated();
            $donor = $request->user();
            $donor->password = Hash::make($data['new_password']);
            $donor->save();
            return response(null);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
  
    public function changeEmail(ChangeDonorEmail $request)
    {
        try {
            $data = $request->validated();
            $donor = $request->user();
            $donor->email = $data['new_email'];
            $donor->save();
            return response(null);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function updatePreferences(UpdateDonorPrefrences $request){
        try {
            $donor = $request->user();
            $donor->update($request->validated());
            return response(null);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }


    public function logout(Request $request){
        try{
            Token::where('api_token' , $request->user()->getCurrentToken())->delete();
            return response(null);
        }catch(\Exception $ex){
         return response()->json(['error' => $ex->getMessage()]);
        }
    }
   
}
