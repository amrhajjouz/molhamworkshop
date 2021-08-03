<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Donor\UpdateDonorRequest;
use App\Models\Donor;
use Illuminate\Http\Request;
use App\Http\Requests\Donor\CreateDonorRequest;
use App\Http\Requests\Donor\AuthenticateDonorRequest;
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
            return response()->json([
                "donor" => [
                    'id' => $donor->id,
                    'name' => $donor->name,
                    'email' => $donor->email,
                ],
                'api_token' => $token->api_token
            ]);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateDonorRequest $request)
    {
        try {
            $donor = Donor::findOrFail($request->id);
            $input = $request->validated();
            if (isset($input["password"])) {
                $input["password"] = Hash::make($request->password);
            }

            $donor->update($input);
            return response()->json($donor);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(Donor::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);

            $donors = Donor::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();

            return response()->json($donors);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function authenticate(AuthenticateDonorRequest $request)
    {
        try {
            $data = $request->validated();
            $donor = Donor::where('email', $data['email'])->first();
            if (!$donor) {
                throw new Exception('email not found', 500);
            }
            if (!Hash::check($data['password'], $donor->password)) throw new Exception('bad credintials', 500);
            $token = $donor->tokens()->create([]);
            return response()->json([
                'id' => $donor->id,
                'name' => $donor->name,
                'email' => $donor->email,
                'api_token' => $token->api_token
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
