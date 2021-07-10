<?php

namespace App\Http\Controllers;

use App\Traits\{ HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Shortcut\{CreateRequest, UpdateRequest, CreateUpdateContent};
use App\Models\{Shortcut};

class ShortcutController extends Controller
{
    use  HasRetrieve;

    public function __construct()
    {
        $this->model = \App\Models\Shortcut::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();
            $shortcut = new Shortcut();
            $shortcut->path  = $data['path'];
            $shortcut->save();
            foreach ($data['contents']  as $content) {
                setContent($shortcut, $content['name'], $content['value'], 'ar');
            }
            return response()->json($shortcut);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $shortcut = Shortcut::findOrFail($request->id);
            $data = $request->all();
            $shortcut->path  = $data['path'];
            $shortcut->save();
            return response()->json($shortcut->contents);
        } catch (\Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $faqs = Shortcut::orderBy('id', 'desc')
                ->join('contents', 'shortcuts.id', 'contents.contentable_id')
                ->where('contents.contentable_type', 'shortcut')
                ->where('contents.name', 'title')
                ->where('contents.locale', 'ar')
                ->where('contents.deleted_at', null)
                ->select('contents.value', 'contents.name as content_name', 'contents.locale', 'shortcuts.*')
                ->where(function ($q) use ($request) {
                    if ($request->has("q")) {
                        $q->where('contents.name', 'like', '%' . $request->q . '%');
                        $q->orWhere('contents.value', 'like', '%' .  $request->q . '%');
                        $q->orWhere('shortcuts.path', 'like', '%' .  $request->q . '%');
                    }
                })->paginate(10)->withQueryString();

            return response()->json($faqs);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Shortcut $shortcut)
    {
        try {
            $data = $request->validated();
            setContent($shortcut, $data['name'], $data['value'], $data['locale']);
            return response()->json($shortcut->contents);
        } catch (\Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function list_keys(Request $request, $id)
    {
        try {
            $model = Shortcut::findOrFail($id);
            return response()->json($model->list_keywords());
        } catch (\Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }
}
