<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortcutKey\{CreateRequest, CreateUpdateContent};
use App\Models\{ShortcutKey};

class ShortcutKeyController extends Controller
{

    public function __construct()
    {
        $this->model = \App\Models\ShortcutKey::class;
    }

    public function create(CreateRequest $request, $shortcut_id)
    {
        try {
            $data = $request->validated();
            $key = new ShortcutKey();
            $key->shortcut_id  = $shortcut_id;
            $key->save();
            setContent($key, 'keyword', $data['value'], 'ar');
            return response()->json($key);
        } catch (\Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function create_update_contents(CreateUpdateContent $request, ShortcutKey $shortcut_key)
    {
        try {
            $data = $request->validated();
            setContent($shortcut_key, $data['name'], $data['value'], $data['locale']);
            return response()->json($shortcut_key->contents);
        } catch (\Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }
}
