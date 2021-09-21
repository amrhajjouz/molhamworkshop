<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Target};
use App\Http\Requests\Target\{ArchiveTargetRequest,  DocumentTargetRequest, HideTargetRequest, PostTargetRequest, UnArchiveTargetRequest, UnDocumentTargetRequest, UnHideTargetRequest};

class TargetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function post(PostTargetRequest $request, $target_id)
    {
        try {
            return response()->json(Target::findOrFail($target_id)->update(['posted_at' => date('Y-m-d H:i:s', time())]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function document(DocumentTargetRequest $request, $target_id)
    {
        try {
            return response()->json(Target::findOrFail($target_id)->update(['documented' => true]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function Undocument(UnDocumentTargetRequest $request, $target_id)
    {
        try {
            return response()->json(Target::findOrFail($target_id)->update(['documented' => false]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function archive(ArchiveTargetRequest $request, $target_id)
    {
        try {
            return response()->json(Target::findOrFail($target_id)->update(['archived' => true]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function unArchive(UnArchiveTargetRequest $request, $target_id)
    {
        try {
            return response()->json(Target::findOrFail($target_id)->update(['archived' => false]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function hide(HideTargetRequest $request, $target_id)
    {
        try {
            return response()->json(Target::findOrFail($target_id)->update(['hidden' => true]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function Unhide(UnHideTargetRequest $request, $target_id)
    {
        try {
            return response()->json(Target::findOrFail($target_id)->update(['hidden' => false]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
