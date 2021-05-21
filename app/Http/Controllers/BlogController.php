<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Facades\Helper;
use App\Models\{Blog, Note, NoteReview};
use App\Http\Requests\Blog\{
    CreateRequest,
    UpdateRequest,
    CreateUpdateContent,

    /////////////// Note 
    CreateNoteRequest,
    UpdateNoteRequest,
    ReviewUnReviewRequest,
};

class BlogController extends BaseController
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

            $blog = new $this->model();
            $blog->url = Helper::formatUrl($data['url'], ' ');

            $blog->save();

            return $this->_response($blog->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $blog = $this->model::findOrFail($request->id);

            $data = $request->validated();
            $blog->url = Helper::formatUrl($data['url'], ' ');

            $blog->save();


            return $this->_response($blog->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function list(Request $request)
    {

        try {
            $search_query = ($request->has('q') ? [['url', 'like', '%' . $request->q . '%']] : null);

            $events = $this->model::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();

            return $this->_response($events);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function create_update_contents(CreateUpdateContent $request, Blog $blog)
    {
        try {
            $data = $request->validated();
            setContent($blog, $data['name'], $data['value'], $data['locale']);
            return $this->_response($blog->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    /////////////////////// Notes /////////////////////////

    public function listing_notes(Request $request, Blog $blog)
    {
        try {
            return $this->_response($blog->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_note(CreateNoteRequest $request, Blog $blog)
    {
        try {
            $data = $request->validated();

            $note = new Note;
            $note->content = $data['content'];

            $blog->notes()->save($note);
            return $this->_response($blog->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function update_note(UpdateNoteRequest $request, $case_id, Note $note)
    {
        try {
            $data = $request->validated();

            $note->content = $data['content'];
            $note->save();

            return $this->_response($note);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function review_note(ReviewUnReviewRequest $request, $case_id, Note $note)
    {
        try {
            $user  = auth()->user();
            $exists = $note->reviews()->where('reviewed_by', $user->id)->first();

            if ($exists) {
                return $this->_response($exists);
            }

            $review = new NoteReview();
            $review->reviewed_by = $user->id;
            $review->note_id = $note->id;
            $review->save();
            return $this->_response($review);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function unreview_note(ReviewUnReviewRequest $request, $case_id, Note $note)
    {
        try {
            $user  = auth()->user();
            $note->reviews()->where('reviewed_by', $user->id)->delete();
            return $this->_response($note);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
}
