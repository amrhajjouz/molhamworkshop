<?php

namespace App\Http\Controllers;

use App\Models\{Donor , Section, Title};
use Illuminate\Http\Request;
use App\Http\Requests\Title\{ SearchTitleRequest};
use Illuminate\Support\Facades\Hash;

class TitleController extends Controller
{
    public function search (SearchTitleRequest $request)
    {
        try {
            $results = [];
            $data = Title::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('name->en', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get();
            foreach ($data as $s) {
                $results[] = ['id' => $s['id'], 'text' => $s['name'][app()->getLocale()]];
            }
            return response()->json($results);
        } catch (\Exception $e) {
            throw response()->json($e->getMessage());
        }
    }
}
