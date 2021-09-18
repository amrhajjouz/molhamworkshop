<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Space\{CreateSpaceRequest, UpdateSpaceRequest,ListSpaceRequest,DeleteSpaceRequest,RetrieveSpaceRequest};
use App\Models\Space;

class SpaceController extends Controller {

    public function create (CreateSpaceRequest $request) {
        try {
            $space = Space::create($request->validated());

            return response()->json($space);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateSpaceRequest $request) {
        try {
            $space = Space::findOrFail($request->id);

            $space->update($request->validated());

            return response()->json($space);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id, RetrieveSpaceRequest $request) {
        try {
            return response()->json(Space::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (ListSpaceRequest $request) {

        try {
            $spaces = Space::orderBy('id', 'desc')->paginate(5);

            return response()->json($spaces);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
