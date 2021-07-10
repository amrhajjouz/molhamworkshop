<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\{HasRetrieve};
use App\Facades\Helper;
use App\Models\{Blog, Note, NoteReview};
use App\Http\Requests\Blog\{ CreateRequest, UpdateRequest, CreateUpdateContent,};

class BlogController extends Controller
{
    use HasRetrieve;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Blog::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();
            $blog = new Blog;
            $blog->url = Helper::formatUrl($data['url'], ' ');
            $blog->save();
            return response()->json($blog->transform());
        } catch (\Exception $e) {
             return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateRequest $request)
    {
        try {

            $blog = $this->model::findOrFail($request->id);
            $data = $request->validated();
            $blog->url = Helper::formatUrl($data['url'], ' ');
            $blog->save();
            return response()->json($blog->transform());
        } catch (\Exception $e) {
             return ['error' => $e->getMessage()];
        }
    }


    public function list(Request $request)
    {
        try {
            $search_query = ($request->has('q') ? [['url', 'like', '%' . $request->q . '%']] : null);
            $blog = $this->model::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();
            return response()->json($blog);
        } catch (\Exception $e) {
             return ['error' => $e->getMessage()];
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Blog $blog)
    {
        try {
            $data = $request->validated();
            setContent($blog, $data['name'], $data['value'], $data['locale']);
            return response()->json($blog->contents);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}
