<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\{CreateCommentRequest , DeleteCommentRequest , ListCommentRequest};
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
            $comments = Comment::where('commentable_type' , $request->commentable_type)->where('commentable_id' , $request->commentable_id)->paginate(null , ['id' , 'body' , 'created_at'])->withQueryString();
            return response()->json($comments);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
   
    public function create(CreateCommentRequest $request)
    {
        try {
            authDonor()->comments()->create($request->validated());
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete(DeleteCommentRequest $request, $id)
    {
        try {
            authDonor()->comments()->where('id',$id)->delete();
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
