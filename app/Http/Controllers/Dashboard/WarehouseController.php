<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warehouse\{CreateWarehouseRequest, UpdateWarehouseRequest,ListWarehouseRequest,DeleteWarehouseRequest,RetrieveWarehouseRequest};
use App\Models\Warehouse;

class WarehouseController extends Controller {

    public function create (CreateWarehouseRequest $request) {
        try {
            $warehouse = Warehouse::create($request->validated());

            return response()->json($warehouse);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateWarehouseRequest $request) {
        try {
            $warehouse = Warehouse::findOrFail($request->id);

            $warehouse->update($request->validated());

            return response()->json($warehouse);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id, RetrieveWarehouseRequest $request) {
        try {
            return response()->json(Warehouse::with('place')->findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (ListWarehouseRequest $request) {

        try {
            $warehouses = Warehouse::with('place')->orderBy('id', 'desc')->paginate(5);

            return response()->json($warehouses);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
