<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Human\{CreateHumanRequest, UpdateHumanRequest};

use App\Models\Human;

class HumanController extends Controller {

    public function __construct () {
        $this->middleware('auth');
    }

    public function create (CreateHumanRequest $request) {

        try {

            return response()->json(Human::create($request->validated()));

        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()]);

        }
    }

    public function update (UpdateHumanRequest $request) {

        try {

            // Fetch Human
            $human = Human::findOrFail($request->id);

            // Update Human
            $human->update($request->validated());

            return response()->json($human);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(Human::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {

        try {
            $humans = Human::orderBy('id', 'asc')->paginate(20);

            return response()->json($humans);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $humans = Human::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', "%" . $request->q . "%");
                    $q->orWhere('last_name', 'like', "%" . $request->q . "%");
                    $q->orWhere('father', 'like', "%" . $request->q . "%");
                    $q->orWhere('mother', 'like', "%" . $request->q . "%");
                    $q->orWhere('email', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()/*->map(function($human) {
                return  ['id'=> $human->id, 'text' => $human->fullname[app()->getLocale()]];
            })*/;
            return response()->json($humans);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $humans =  Human::find($id)->delete();
            return response()->json($humans);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
