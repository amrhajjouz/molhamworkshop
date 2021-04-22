<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Http\Requests\ShortcutKey\{CreateRequest, CreateUpdateContent};
use App\Models\{ ShortcutKey};

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
