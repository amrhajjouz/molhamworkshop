<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList, HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Shortcut\{CreateRequest, UpdateRequest , CreateUpdateKeywordsContent};
use App\Models\{User, Shortcut, Content};
use App\Facades\Helper;

class ShortcutController extends BaseController
{
    use HasList, HasRetrieve;

    public function __construct()
    {
        $this->model = \App\Models\Shortcut::class;
    }

    public function create(CreateRequest $request)
    {
        try {

            $data = $request->validated();

            $shortcut = new $this->model();
            $shortcut->path  = $data['path'];
            $shortcut->save();
            setContent($request, $shortcut);

            return $this->_response($shortcut);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function update(UpdateRequest $request)
    {
        try {
            
            $shortcut = $this->model::findOrFail($request->id);
            $data = $request->all();
            $shortcut->path  = $data['path'];
            $shortcut->save();
            setContent($request, $shortcut);

            return $this->_response($shortcut->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {

            $faqs = $this->model::orderBy('id', 'desc')
                ->join('contents', 'faqs.id', 'contents.contentable_id')
                ->join('categories', 'faqs.category_id', 'categories.id')
                ->where('contents.contentable_type', 'App\Models\Shortcut')
                ->select('contents.value', 'contents.name', 'contents.locale', 'faqs.*' , 'categories.name as category')
                ->where(function ($q) use ($request) {
                    if ($request->has("q")) {
                        $q->where('contents.name', 'like', '%' .$request-> q . '%');
                        $q->orWhere('contents.value', 'like', '%' .  $request->q . '%');
                        $q->orWhere('categories.name', 'like', '%' .  $request->q . '%');
                    }
                })
                ->paginate(10)
                ->withQueryString();

            return $this->_response($faqs);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }




    public function list_keywords(Request $request, $id)
    {

        try {

            $model = $this->model::findOrFail($id);
            return $this->_response($model->list_keywords());
            return $this->_response(getContent($model));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_update_keywords_contents(CreateUpdateKeywordsContent $request, $id)
    {
        try {

            $model = $this->model::find($id);

            setContent($request, $model);

            return $this->_response($model->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }




}
