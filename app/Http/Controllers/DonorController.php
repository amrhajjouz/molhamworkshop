<?php

namespace App\Http\Controllers;

use App\Http\Requests\Donor\UpdateDonorRequest;
use App\Models\{User, Donor};
use Illuminate\Http\Request;
use App\Http\Requests\Donor\CreateDonorRequest;
use Illuminate\Support\Facades\Hash;

class DonorController extends Controller
{

    public function create (CreateDonorRequest $request)
    {
        try {
            
            $data = $request->validated();
            $data["password"] = Hash::make($request->password);
            $donor = Donor::create($data);
            
            $user = User::find(1);
            
            $user->notifications()->create([
                "name" => "new_donor",
                'data' => [
                    'user_name' => auth()->user()->name, 
                    'donor_id' => $donor->id, 
                ],
            ]);
            
            return response()->json($donor);
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update (UpdateDonorRequest $request)
    {
        try {
            $donor = Donor::findOrFail($request->id);
            $input = $request->validated();
            if(isset($input["password"])){
                $input["password"] = Hash::make($request->password);
            }

            $donor->update($input);
            return response()->json($donor);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve ($id)
    {
        try {
            return response()->json(Donor::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list (Request $request) {
        
        try {
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);
            
            $donors = Donor::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();
            
            return response()->json($donors);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
