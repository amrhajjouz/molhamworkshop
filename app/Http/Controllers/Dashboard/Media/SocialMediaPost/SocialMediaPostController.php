<?php

namespace App\Http\Controllers\Dashboard\Media\SocialMediaPost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\SocialMediaPost\{ApproveSocialMediaPostRequest, ProofreadSocialMediaPostRequest, CreateSocialMediaPostRequest, RejectSocialMediaPostRequest, UpdateSocialMediaPostPublishingOptions, UpdateSocialMediaPostRequest};
use App\Models\{SocialMediaPost};

class SocialMediaPostController extends Controller
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

    public function create(CreateSocialMediaPostRequest $request)
    {
        try {
            $socialMediaPost = SocialMediaPost::create($request->validated());
            return response()->json($socialMediaPost);
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

    public function update(UpdateSocialMediaPostRequest $request)
    {
        try {
            $socialMediaPost = SocialMediaPost::findOrFail($request->id);
            $socialMediaPost->updateContentFields($request->validated());
            $socialMediaPost->update(['description' => $request->validated()['description']]);
            return response()->json($socialMediaPost);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsProofread(ProofreadSocialMediaPostRequest $request, $id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id)->markAsProofread('ar'));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsRejected(RejectSocialMediaPostRequest $request, $id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id)->update(['status' => 'rejected', 'rejected_at' => date('Y-m-d H:i:s', time()), 'rejected_by' => auth()->id()]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function markAsApproved(ApproveSocialMediaPostRequest $request, $id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id)->update(['status' => 'approved', 'approved_at' => date('Y-m-d H:i:s', time()), 'approved_by' => auth()->id()]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateSocialMediaPostPublishingOptions(UpdateSocialMediaPostPublishingOptions $request, $id)
    {
        $post = SocialMediaPost::findOrFail($id);
        foreach ($request->validated()['publishing'] as $type => $value) {
            if($value==true && $post->$type == null) $post->$type = date('Y-m-d H:i:s', time());
            else $post->$type = null;
        }
        foreach ($request->validated()['scheduling'] as $type => $value) {
            if($value ) $post->$type = $value;
            else $post->$type = null;
        }
        $post->save();
        return response()->json(null);
    }
}
