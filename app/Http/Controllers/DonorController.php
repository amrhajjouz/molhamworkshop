<?php

namespace App\Http\Controllers;

 use App\Http\Requests\Donor\UpdateDonorRequest;
  use App\Models\Donor;
 use Illuminate\Http\Request;
 use App\Http\Requests\Donor\CreateDonorRequest;
class DonorController extends Controller
{

    public function create (CreateDonorRequest $request) {
        try {
            $donor = Donor::create($request->validated());
            return response()->json($donor);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update (UpdateDonorRequest $request) {
        try {
            $donor = Donor::findOrFail($request->id);
            $input = $request->validated();
            $donor->update($input);
            return response()->json($donor);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(Donor::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list (Request $request) {
        try {
            return response()->json(Donor::all());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
