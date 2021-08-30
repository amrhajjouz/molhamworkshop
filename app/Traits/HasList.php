<?php

namespace App\Traits;

use Illuminate\Http\Request;
trait HasList
{
    public function list(Request $request)
    {
        try {
            $class_name = $this->model;
            $response = $class_name::all();
            return response()->json($response);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}