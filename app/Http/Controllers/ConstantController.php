<?php

namespace App\Http\Controllers;

use App\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Constant\{CreateRequest, UpdateRequest , CreateUpdateContent};
use App\Models\{Constant};

class ConstantController extends Controller
{
    use HasRetrieve;

    public function __construct()
    {
        $this->model = \App\Models\Constant::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();
            $constant = new $this->model();
            $constant->plaintext = $data['plaintext'];
            $constant->name = $data['name'];
            $constant->save();
            setContent($constant, $data['content']['name'], $data['content']['value'], 'ar');
            return response()->json($constant);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            
            $data = $request->validated();
            $constant = $this->model::findOrFail($request->id);
            $constant->plaintext = $data['plaintext'];
            $constant->name = $data['name'];
            $constant->save();
            return response()->json($constant);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try { 
            $constants = $this->model::orderBy('id', 'desc')
                ->leftJoin('contents AS CAR', function ($join) {
                    $join->on('constants.id', '=', 'CAR.contentable_id')
                    ->where('CAR.contentable_type', 'constant')
                    ->where('CAR.name', 'body')
                    ->where('CAR.locale', 'ar')
                    ->where('CAR.deleted_at', null);
                })
                ->leftJoin('contents AS CEN', function ($join) {
                    $join->on('constants.id', '=', 'CEN.contentable_id')
                    ->where('CEN.contentable_type', 'constant')
                    ->where('CEN.name', 'body')
                    ->where('CEN.locale', 'en')
                    ->where('CEN.deleted_at', null);
                })
                ->select('CAR.value AS ar_body', 'CEN.value AS en_body', 'constants.*')
                ->where(function ($q) use ($request) {
                    if ($request->has("q")) {
                        $q->orWhere('CEN.value', 'like', '%' .  $request->q . '%');
                        $q->orWhere('CAR.value', 'like', '%' .  $request->q . '%');
                    }
                })
                ->paginate(2000)
                ->withQueryString();;
            return response()->json($constants);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function listJson(Request $request) {
        $constants = [];
        foreach (Constant::with('contents')->get() as $c) {
            $content = [];
            foreach ($c['contents'] as $con) $content[$con['locale']] = $con['value'];
            $constants[$c['name']] = $content;
        }
        return response()->json($constants);
    }
    
    public function listJson2(Request $request) {
        $constants = [];
        foreach (Constant::with('contents')->get() as $c) {
            $content = [];
            foreach ($c['contents'] as $con) $constants[$con['locale']][$c['name']] = $con['value'];
        }
        return response()->json($constants);
    }
    public function create_update_contents(CreateUpdateContent $request, Constant $constant)
    {
        try {
            $data = $request->validated();
            setContent($constant, $data['name'], $data['value'], $data['locale']);
            return response()->json($constant->contents);
        } catch (\Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }
}
