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

            //TODO add dummy data paymentmethods
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

    public function testApple(Request $request){
        \Laravel\Socialite\Facades\Socialite::driver('apple')->redirect();
    }
    public function CallbackTestApple(Request $request){
        $user = \Laravel\Socialite\Facades\Socialite::driver('github')->user();
        // id
        // name
        // email
    }
}
