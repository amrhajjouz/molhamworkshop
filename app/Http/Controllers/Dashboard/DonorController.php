<?php

namespace App\Http\Controllers;

use App\Http\Requests\Donor\CreateAgreementRequest;
use App\Http\Requests\Donor\UpdateDonorRequest;
use App\Models\Donor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DonorController extends Controller
{

    public function create(CreateAgreementRequest $request)
    {
        try {
            $data = $request->validated();
            $data["password"] = Hash::make($request->password);
            $donor = Donor::create($data);
            return response()->json($donor);

        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
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
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(Donor::findOrFail($id));
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list(Request $request)
    {

        try {
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);

            $donors = Donor::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();

            return response()->json($donors);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $donors = Donor::where('name', 'like', "%{$request->q}%")
                ->Orwhere('email', 'like', "%{$request->q}%")
                ->Orwhere('id', 'like', "%{$request->q}%")
                ->select("name", "id", "email")
                ->get()
                ->map(function ($donor) {
                    return [
                        "id" => $donor->id,
                        "text" => "{$donor->name} - {$donor->email} - [ {$donor->id} ]"
                    ];
                });
            return response()->json($donors);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
