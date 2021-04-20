<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList, HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Constant\{CreateRequest, UpdateRequest};
use App\Models\{User, Constant, Content};
use App\Facades\Helper;

class ConstantController extends BaseController
{
    use HasList, HasRetrieve;

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

            $constant->save();

            setContent($constant , $data['content']['name'] , $data['content']['value'] ,'ar' );

            return $this->_response($constant);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $data = $request->validated();

            $constant = $this->model::findOrFail($request->id);
            $constant->plaintext = $data['plaintext'];

            $constant->save();

            $content = $constant->content;

            $content->name = $data['content']['name'];
            $content->value = $data['content']['value'];
            $content->locale = $data['content']['locale'];

            $content->save();


            return $this->_response($constant);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {
            // $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);

            $constants = $this->model::orderBy('id', 'desc')
                ->join('contents', 'constants.id', 'contents.contentable_id')
                ->where('contents.contentable_type', 'App\Models\Constant')
                ->select('contents.value', 'contents.name', 'contents.locale', 'constants.*')
                ->where(function ($q) use ($request) {
                    if ($request->has("q")) {
                        $q->where('contents.name', 'like', '%' .$request-> q . '%');
                        $q->orWhere('contents.value', 'like', '%' .  $request->q . '%');
                    }
                })
                ->paginate(10)
                ->withQueryString();

            return $this->_response($constants);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
}
