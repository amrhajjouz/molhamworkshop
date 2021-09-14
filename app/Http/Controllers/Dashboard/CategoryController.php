<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function list (Request $request)
    {
        
        try {
            return response()->json(Category::all());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
