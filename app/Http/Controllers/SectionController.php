<?php

namespace App\Http\Controllers;

use App\Models\{Section};
use Illuminate\Http\Request;
use App\Http\Requests\Section\{CreateSectionRequest , SearchSectionRequest, UpdateSectionRequest};

class SectionController extends Controller
{
    public function create(CreateSectionRequest $request)
    {
        try {
            return response()->json(Section::create($request->validated()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateSectionRequest $request)
    {
        try {
            $data = $request->validated();
            $section = Section::findOrFail($data['id']);
            $section->update($data);
            return response()->json($section);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(Section::findOrFail($id)->transform());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $sections = Section::orderBy('id', 'desc')->where(function($q)use($request){
                if($request->has('q')){
                    $q->where('name->ar' , 'like' , '%' . $request->q . '%');
                    $q->orWhere('name->en' , 'like' , '%' . $request->q . '%');
                }
            })->with('parent')->paginate(5)->withQueryString();
            return response()->json($sections);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function search (SearchSectionRequest $request)
    {
        try {
            $results = [];
            $data = Section::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('name->en', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get();
            $locale = app()->getLocale();
            foreach ($data as $s) {
                $results[] = ['id' => $s['id'], 'text' => $s['name'][$locale]];
            }
            return response()->json($results);
        } catch (\Exception $e) {
            throw response()->json($e->getMessage());
        }
    }
}
