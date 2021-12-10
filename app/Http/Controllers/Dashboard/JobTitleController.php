<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserContract;
use App\Http\Requests\JobTitle\{CreateJobTitleRequest, UpdateJobTitleRequest,ListJobTitleRequest,DeleteJobTitleRequest,RetrieveJobTitleRequest};
use App\Models\JobTitle;
use Illuminate\Http\Request;

class JobTitleController extends Controller {

    public function create (CreateJobTitleRequest $request) {
        try {
            $job_title = JobTitle::create($request->validated());

            return response()->json($job_title);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateJobTitleRequest $request) {
        try {
            $job_title = JobTitle::findOrFail($request->id);

            $job_title->update($request->validated());

            return response()->json($job_title);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(JobTitle::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {
        try {
            return response()->json(JobTitle::orderBy('id', 'asc')->where(function($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('name->en', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        try {
            $job_title = JobTitle::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('name->en', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()->map(function($job_title) {
                return  ['id'=> $job_title->id, 'text' => $job_title->name[app()->getLocale()]];
            });
            return response()->json($job_title);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
