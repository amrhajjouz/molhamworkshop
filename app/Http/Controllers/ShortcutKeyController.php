<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use Illuminate\Http\Request;
use App\Http\Requests\ShortcutKey\{CreateRequest, UpdateRequest , CreateKeyword , UpdateKeyword , ListContentRequest , CreateUpdateContent};
use App\Models\{User, Shortcut, Content , ShortcutKey};

class ShortcutKeyController extends BaseController
{

    public function __construct()
    {
        $this->model = \App\Models\ShortcutKey::class;
    }

    public function create(CreateRequest $request , $shortcut_id)
    {
        try {

            $data = $request->validated();
            $key = new $this->model();
            $key->shortcut_id  = $shortcut_id;
            $key->save();

                setContent($key, 'keyword' , $data['value'] , 'ar' );

            return $this->_response($key);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
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


    public function retrive(Request $request , ShortcutKey $shortcut_key){
        try {
            return $this->_response(getContent($shortcut_key));
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }
    

    // public function list_contents(ListContentRequest $request, Shortcut $shortcut)
    // {
    //     $res = [];

    //     foreach ($shortcut->keys as $key) {
    //         dd($key->contents);

    //     }
    //     try {
    //         return $this->_response(getContent($shortcut, $request));
    //     } catch (\Exception $ex) {
    //         throw $this->_exception($ex->getMessage());
    //     }
    // }

    public function create_update_contents(CreateUpdateContent $request, ShortcutKey $shortcut_key)
    {
        try {
            $data = $request->validated();
            setContent($shortcut_key, $data['name'], $data['value'], $data['locale']);
            return $this->_response($shortcut_key->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }





}
