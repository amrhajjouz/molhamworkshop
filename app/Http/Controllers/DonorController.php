<?php

namespace App\Http\Controllers;

use App\Http\Requests\Donor\UpdateDonorRequest;
use App\Models\Donor;
use Illuminate\Http\Request;
use App\Http\Requests\Donor\CreateDonorRequest;
use Illuminate\Support\Facades\Hash;

class DonorController extends Controller
{

    public function create(CreateDonorRequest $request)
    {
        try {
            $data = $request->validated();
            $data["password"] = Hash::make($request->password);
            $donor = Donor::create($data);
            return response()->json($donor);
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

    public function list()
    {
        try {
            return response()->json(Donor::all());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }




    public function search(Request $request)
    {

        try {

            $result = [];
            $data = null;

            $data = Donor::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', "%" . $request->q . "%")
                      ->orWhere('email', 'like', "%" . $request->q . "%")
                      ->orWhere('phone', 'like', "%" . $request->q . "%");
                }
            })
                ->take(10)
                ->get();

            foreach ($data as $item) {

                $obj = new \stdClass();
                $obj->id = $item->id;
                $obj->name = $item->name;
                $obj->text = $item->name;

                $result[] = $obj;
            }

            return response()->json($result);
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }
}
