<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList, HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Shortcut\{CreateRequest, UpdateRequest , CreateKeyword , UpdateKeyword , ListContentRequest , CreateUpdateContent};
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

            foreach($data['contents']  as $content){
                setContent($shortcut, $content['name'] , $content['value'] , 'ar' );
            }

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


            return $this->_response($shortcut->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {

            $faqs = $this->model::orderBy('id', 'desc')
                ->join('contents', 'shortcuts.id', 'contents.contentable_id')
                ->where('contents.contentable_type', 'App\Models\Shortcut')
                ->where('contents.name', 'title')
                ->where('contents.locale', 'ar')
                ->select('contents.value', 'contents.name as content_name', 'contents.locale', 'shortcuts.*' )
                ->where(function ($q) use ($request) {
                    if ($request->has("q")) {
                        $q->where('contents.name', 'like', '%' .$request-> q . '%');
                        $q->orWhere('contents.value', 'like', '%' .  $request->q . '%');
                        $q->orWhere('shortcuts.path', 'like', '%' .  $request->q . '%');
                    }
                })
                ->paginate(10)
                ->withQueryString();

            return $this->_response($faqs);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }




    public function list_contents(ListContentRequest $request, Shortcut $shortcut)
    {
        try {
            return $this->_response(getContent($shortcut, $request));
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Shortcut $shortcut)
    {
        try {
            $data = $request->validated();
            setContent($shortcut, $data['name'], $data['value'], $data['locale']);
            return $this->_response($shortcut->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }


    public function list_keys(Request $request, $id)
    {
        try {
            
            $model = $this->model::findOrFail($id);

            return $this->_response($model->list_keywords());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }


}
