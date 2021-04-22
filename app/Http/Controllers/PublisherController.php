<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList, HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Publisher\{
    CreateRequest,
    CreateUpdateContent
};
use App\Models\{Publisher};

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

            foreach ($data['contents']  as $content) {
                setContent($publisher, $content['name'], $content['value'], 'ar');
            }

            return $this->_response($publisher);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function list(Request $request)
    {

        try {

            $publishers = $this->model::orderBy('id', 'desc')
                ->leftJoin('contents AS CAR', function ($join) {
                    $join->on('publishers.id', '=', 'CAR.contentable_id')
                        ->where('CAR.contentable_type', 'publisher')
                        ->where('CAR.name', 'name')
                        ->where('CAR.locale', 'ar')
                        ->where('CAR.deleted_at', null);
                })
                ->leftJoin('contents AS CEN', function ($join) {
                    $join->on('publishers.id', '=', 'CEN.contentable_id')
                        ->where('CEN.contentable_type', 'publisher')
                        ->where('CEN.name', 'name')
                        ->where('CEN.locale', 'en')
                        ->where('CEN.deleted_at', null);
                })
                ->select('CAR.value AS ar_name', 'CEN.value AS en_name', 'publishers.*')
                ->where(function ($q) use ($request) {
                    if ($request->has("q")) {
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


    public function create_update_contents(CreateUpdateContent $request, Publisher $publisher)
    {
        try {
            $data = $request->validated();
            setContent($publisher, $data['name'], $data['value'], $data['locale']);
            return $this->_response($publisher->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }
}
