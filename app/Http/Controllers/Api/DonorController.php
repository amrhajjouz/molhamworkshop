<?php

namespace App\Http\Controllers\Api;

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
            DonorMailer::sendResetPasswordLink($donor, $donorResetPasswordRequest->code);
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function confirmResetPasswordRequest(ConfirmDonorResetPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $resetPasswordRequest = DonorResetPasswordRequest::where([['code', $data['code']], ['expires_at', ">", Carbon::now()->toDateTimeString()], ['consumed', 0]])->first();
            if (!$resetPasswordRequest) throw new ApiException('invalid_confirm_donor_reset_password_request');
            $donor = Donor::findOrFail($resetPasswordRequest->donor_id);
            $donor->password = Hash::make($data['new_password']);
            $donor->save();
            $resetPasswordRequest->consumed = true;
            $resetPasswordRequest->save();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function retrieveResetPasswordRequest($code)
    {
        try {
            $resetPasswordRequest = DonorResetPasswordRequest::where([['code', $code], ['expires_at', ">", Carbon::now()->toDateTimeString()], ['consumed', 0]])->firstOrFail();
            $donor = $resetPasswordRequest->donor;
            return handleResponse(['name' => $donor->name, 'email' => $donor->email]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
