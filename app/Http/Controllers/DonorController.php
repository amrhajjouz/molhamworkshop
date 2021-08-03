<?php

namespace App\Http\Controllers;

 use App\Http\Requests\Donor\UpdateDonorRequest;
  use App\Models\Donor;
 use Illuminate\Http\Request;
 use App\Http\Requests\Donor\CreateDonorRequest;
use App\Http\Requests\Donor\AuthenticateDonorRequest;
use Illuminate\Support\Facades\Hash;
use Exception;

 class DonorController extends Controller
{

    public function create (CreateDonorRequest $request)
    {
        try {
            $data = $request->validated();
            $data["password"] = Hash::make($request->password);
            $donor = Donor::create($data);
            $token = $donor->tokens()->create([]);
            return response()->json([
                'id' => $donor->id , 
                'name' => $donor->name , 
                'email' => $donor->email , 
                'api_token' => $token->api_token
            ]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



}
