<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\{CreateCommentRequest, DeleteCommentRequest, ListCommentRequest, UpdateCommentRequest};
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor');
    }

    public function list(ListCommentRequest $request)
    {
        try {
            $comments = Comment::where('commentable_type', $request->commentable_type)->where('commentable_id', $request->commentable_id)->paginate(null, ['id', 'body', 'created_at'])->withQueryString();
            return response()->json($comments);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function create(CreateCommentRequest $request)
    {
        try {
            $data = array_merge($request->validated() , ['commenter_type' => 'donor' , 'commenter_id' => authDonor()->id]);
            Comment::create($data);
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateCommentRequest $request)
    {
        try {
            $comment = Comment::where(['commentable_type' => $request->commentable_type, 'commentable_id' => $request->commentable_id , 'commenter_type' => 'donor' , 'commenter_id' => authDonor()->id])->firstOrFail();
            $comment->update(['body' => $request->validated()['body']]);
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete(DeleteCommentRequest $request, $id)
    {
        try {
            Comment::findOrFail($id)->delete();
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
