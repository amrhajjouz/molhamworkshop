<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Models\Donor;
use App\Http\Requests\Api\Donor\{CreateDonorRequest, AuthenticateDonorRequest, CreateDonorResetPasswordRequest, ConfirmDonorResetPasswordRequest};
use App\Models\DonorResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Facades\DonorMailer;
use Exception;
use Carbon\Carbon;

class DonorController extends Controller
{
    public function create(CreateDonorRequest $request)
    {
        try {
            $data = $request->validated();
            $data["password"] = Hash::make($request->password);
            $data['email_verification_token'] = Str::random(60);
            do {$data['email_verification_token']  = Str::random(60);
             }while(Donor::where('email_verification_token' , $data['email_verification_token'])->exists());
            $donor = Donor::create($data);
            $token = $donor->tokens()->create([]);
            createRandomPaymentMethods($donor->id);
                
            return handleResponse([
                'id' => $donor->id,
                'name' => $donor->name,
                'email' => $donor->email,
                'access_token' => $token->access_token , 
            ]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function authenticate(AuthenticateDonorRequest $request)
    {
        try {
            $data = $request->validated();
            $donor = Donor::where('email', $data['email'])->first();
            if (!$donor)  throw new Exception('bad_credintials');
            if (!Hash::check($data['password'], $donor->password)) throw new Exception('bad_credintials');
            $token = $donor->tokens()->create([]);
            return handleResponse(['id' => $donor->id, 'name' => $donor->name, 'email' => $donor->email, 'locale' => $donor->locale, 'currency' => $donor->currency, 'access_token' => $token->access_token]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function createResetPasswordRequest(CreateDonorResetPasswordRequest $request)
    {
        try {
            $donor = Donor::where('email', $request->validated()['email'])->first();
            if (!$donor) throw new Exception('reset_donor_password_invalid_email');
            if ($donor->reset_password_requests()->where([['expires_at', ">", Carbon::now()->toDateTimeString()], ['consumed', 0]])->get()->count() >= 3) throw new ApiException('max_exceed_donor_reset_password_requests');
            $donorResetPasswordRequest = $donor->reset_password_requests()->create([]);
            DonorMailer::sendResetPasswordCode($donor, $donorResetPasswordRequest->code);
            return handleResponse(['token' => $donorResetPasswordRequest->token]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function retrieveResetPasswordRequest(Request $request, $token)
    {
        try {
            $resetPasswordRequest = DonorResetPasswordRequest::where([['token', $token], ['code', $request->code], ['expires_at', ">", Carbon::now()->toDateTimeString()], ['consumed', 0] , ['attempts' , '<' , 3]])->first();
            if (!$resetPasswordRequest)  throw new Exception('invalid_donor_reset_password_request');
            $resetPasswordRequest->attempts +=1;
            $resetPasswordRequest->save();
            $donor = $resetPasswordRequest->donor;
            return handleResponse(['name' => $donor->name, 'email' => $donor->email]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }
    
    public function confirmResetPasswordRequest(ConfirmDonorResetPasswordRequest $request, $token)
    {
        try {
            $data = $request->validated();
            $resetPasswordRequest = DonorResetPasswordRequest::where([['token', $token], ['code', $data['code']], ['expires_at', ">", Carbon::now()->toDateTimeString()], ['consumed', 0]])->first();
            if (!$resetPasswordRequest) throw new ApiException('invalid_confirm_donor_reset_password_request');
            $donor = Donor::find($resetPasswordRequest->donor_id);
            if (!$donor) throw new ApiException('invalid_donor');
            $donor->password = Hash::make($data['new_password']);
            $donor->save();
            $resetPasswordRequest->consumed = true;
            $resetPasswordRequest->save();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }
  
   
}
