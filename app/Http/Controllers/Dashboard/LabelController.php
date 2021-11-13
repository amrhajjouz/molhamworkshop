<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Label\{CreateLabelRequest, UpdateLabelRequest, ListLabelRequest, DeleteLabelRequest, RetrieveLabelRequest};
use App\Models\Label;

class LabelController extends Controller
{

    public function create(CreateLabelRequest $request)
    {
        try {
            $label = Label::create($request->validated());

            return response()->json($label);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateLabelRequest $request)
    {
        try {
            $label = Label::findOrFail($request->id);

            $label->update($request->validated());

            return response()->json($label);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($id, RetrieveLabelRequest $request)
    {
        try {
            return response()->json(Label::with('board')->findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list(ListLabelRequest $request)
    {

        try {
            $labels = Label::with('board')->orderBy('id', 'desc')->paginate(5);

            return response()->json($labels);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function remove($id)
    {

        try {
            Label::destroy($id);

            return response()->json();
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
