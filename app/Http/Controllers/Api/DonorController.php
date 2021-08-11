<?php

namespace App\Http\Controllers\Api;

use App\Models\Donor;
use App\Http\Requests\Api\Donor\{CreateDonorRequest, AuthenticateDonorRequest, CreateDonorResetPasswordRequest, ConfirmDonorResetPasswordRequest};
use App\Models\DonorResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
            $token = Str::random(100);
            do {
                $token = Str::random(100);
            } while (DonorResetPasswordRequest::where('token', $token)->exists());
            DonorResetPasswordRequest::create(['donor_id' => Donor::where('email', $request->validated()['email'])->firstOrFail()->id, 'token' => $token, 'expires_at' =>  Carbon::now()->addMinutes(10)->toDateTimeString()]);
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function confirmResetPasswordRequest(ConfirmDonorResetPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $resetPassword = DonorResetPasswordRequest::where('token', $data['token'])->where('expires_at', ">", Carbon::now()->toDateTimeString())->firstOrFail();
            $donor = Donor::findOrFail($resetPassword->donor_id);
            $donor->password = Hash::make($data['new_password']);
            $donor->save();
            $resetPassword->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function retrieveResetPasswordRequest($token)
    {
        try {
            $resetPasswordRequest = DonorResetPasswordRequest::where('token', $token)->firstOrFail();
            $donor = $resetPasswordRequest->donor;
            return handleResponse(['name' => $donor->name, 'email' => $donor->email]);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }
}
