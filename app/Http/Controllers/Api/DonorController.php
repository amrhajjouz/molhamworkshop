<?php

namespace App\Http\Controllers\Api;

use App\Models\Donor;
use App\Http\Requests\Api\Donor\{CreateDonorRequest, AuthenticateDonorRequest};
use Illuminate\Support\Facades\Hash;
use Exception;

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
}
