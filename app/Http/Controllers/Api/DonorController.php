<?php

namespace App\Http\Controllers\Api;

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
            $donor = Donor::create($data);
            $token = $donor->tokens()->create([]);
            createRandomPaymentMethods($donor->id);
            return handleResponse([
                'id' => $donor->id,
                'name' => $donor->name,
                'email' => $donor->email,
                'access_token' => $token->access_token
            ]);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
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
            return handleResponse([
                'id' => $donor->id,
                'name' => $donor->name,
                'email' => $donor->email,
                'access_token' => $token->access_token
            ]);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function createResetPasswordRequest(CreateDonorResetPasswordRequest $request)
    {
        try {
            
            $donor = Donor::where('email', $request->validated()['email'])->first();
            if (!$donor) throw new Exception('reset_donor_password_invalid_email');
            
            $token = Str::random(100);
            do {
                $token = Str::random(100);
            } while (DonorResetPasswordRequest::where('token', $token)->exists());
            
            $donorResetPasswordRequest = DonorResetPasswordRequest::create(['donor_id' => $donor->id, 'token' => $token, 'expires_at' =>  Carbon::now()->addMinutes(10)->toDateTimeString()]);
            return DonorMailer::sendResetPasswordLink($donor, $donorResetPasswordRequest->token);
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function confirmResetPasswordRequest(ConfirmDonorResetPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $resetPasswordRequest = DonorResetPasswordRequest::where('token', $data['token'])->where('expires_at', ">", Carbon::now()->toDateTimeString())->where('consumed', 0)->firstOrFail();
            $donor = Donor::findOrFail($resetPasswordRequest->donor_id);
            $donor->password = Hash::make($data['new_password']);
            $donor->save();
            $resetPasswordRequest->consumed = true;
            $resetPasswordRequest->save();
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function retrieveResetPasswordRequest($token)
    {
        try {
            $resetPasswordRequest = DonorResetPasswordRequest::where('token', $token)->where('expires_at', ">", Carbon::now()->toDateTimeString())->where('consumed', 0)->firstOrFail();
            $donor = $resetPasswordRequest->donor;
            return handleResponse(['name' => $donor->name, 'email' => $donor->email]);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }
}
