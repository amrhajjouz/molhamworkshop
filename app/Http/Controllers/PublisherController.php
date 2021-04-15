<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList, HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Publisher\{CreateRequest, UpdateRequest};
use App\Models\{User, Publisher, Content};
use App\Facades\Helper;

class PublisherController extends BaseController
{
    use HasList, HasRetrieve;

    public function __construct()
    {
        $this->model = \App\Models\Publisher::class;
    }

    public function create(CreateRequest $request)
    {
        try {

            $data = $request->validated();
            $publisher = new $this->model();
            $publisher->save();
            setContent($request, $publisher);

            return $this->_response($publisher);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function update(UpdateRequest $request)
    {
        try {

            $model = $this->model::findOrFail($request->id);
            $model->save();
            setContent($request->all(), $model);

            return $this->_response($model->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {

            $publishers = $this->model::orderBy('id', 'desc')
                ->leftJoin('contents AS CAR', function ($join) {
                    $join->on('publishers.id', '=', 'CAR.contentable_id')
                        ->where('CAR.contentable_type', 'App\Models\Publisher')
                        ->where('CAR.name', 'name')
                        ->where('CAR.locale', 'ar');
                })
                ->leftJoin('contents AS CEN', function ($join) {
                    $join->on('publishers.id', '=', 'CEN.contentable_id')
                        ->where('CEN.contentable_type', 'App\Models\Publisher')
                        ->where('CEN.name', 'name')
                        ->where('CEN.locale', 'en');
                })
                ->select('CAR.value AS ar_name', 'CEN.value AS en_name', 'publishers.*')
                ->where(function ($q) use ($request) {
                    if ($request->has("q")) {
                        // $q->orWhere('CAR.ar_title', 'like', '%' .  $request->q . '%');
                        $q->orWhere('CEN.value', 'like', '%' .  $request->q . '%');
                        $q->orWhere('CAR.value', 'like', '%' .  $request->q . '%');
                    }
                })->paginate(10)
            ->withQueryString();;
            return $this->_response($publishers);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }




}
