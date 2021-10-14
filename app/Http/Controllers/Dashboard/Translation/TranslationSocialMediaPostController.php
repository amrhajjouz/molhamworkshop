<?php

namespace App\Http\Controllers\Dashboard\Translation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{SocialMediaPost};
use App\Http\Requests\Translation\SocialMediaPost\{UpdateTranslationSocialMediaPostRequest , ProofreadTranslationSocialMediaPostRequest};

class TranslationSocialMediaPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(SocialMediaPost::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('body->ar->value', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateTranslationSocialMediaPostRequest $request)
    {
        try {
            $socialMediaPost = SocialMediaPost::findOrFail($request->id);
            $socialMediaPost->updateContentFields($request->validated());
            return response()->json($socialMediaPost);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsProofread(ProofreadTranslationSocialMediaPostRequest $request, $id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id)->markAsProofread('en'));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
