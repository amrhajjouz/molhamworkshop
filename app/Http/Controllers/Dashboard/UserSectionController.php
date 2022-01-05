<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSection\{CreateUserSectionRequest, UpdateUserSectionRequest};
use App\Models\UserSection;
use Illuminate\Http\Request;

class UserSectionController extends Controller {

    public function create (CreateUserSectionRequest $request) {
        try {
            $user_section = UserSection::create($request->validated());

            return response()->json($user_section);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserSectionRequest $request) {
        try {
            $user_section = UserSection::findOrFail($request->id);

            $user_section->update($request->validated());

            return response()->json($user_section);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(UserSection::with(['managerUser'])->where('id', $id)->firstOrFail());
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {

        /*try {

            $user_sections = UserSection::orderBy('id', 'desc')->paginate(5);
            return response()->json($user_sections);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }*/
        try {
            return response()->json(UserSection::orderBy('id', 'asc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('section_name->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('section_name->en', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        try {
            $sections = UserSection::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('section_name->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('section_name->en', 'like', "%" . $request->q . "%");
                    //$q->orWhere('name->en', 'like', "%" . $request->q . "%");
                    //$q->orWhere('fullname->ar', 'like', "%" . $request->q . "%");
                    //$q->orWhere('fullname->en', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()->map(function($section) {
                return  ['id'=> $section->id, 'text' => $section->section_name[app()->getLocale()]];
            });
            return response()->json($sections);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}

