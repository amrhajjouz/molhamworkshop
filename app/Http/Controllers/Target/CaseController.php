<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Facades\Files;
use Illuminate\Http\Request;

use App\Facades\Helper;
use App\Models\{Cases, Status, Note, NoteReview , Card, Comment, File};

use App\Http\Requests\Target\Cases\{
    CreateRequest,
    UpdateRequest,
    CreateUpdateContent,
    ListContentRequest,
    CreateStatusRequest,
    UpdateStatusRequest ,
    CreateNoteRequest ,
    UpdateNoteRequest ,
    /////////////////////// Cards
    CreateCardRequest,
    UpdateCardRequest,
    CreateCommentRequest,
    UpdateCommentRequest,
};
use App\Jobs\ImportDriveFile;

class CaseController extends BaseController
{

    use HasRetrieve;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Cases::class;
    }

    public function create(CreateRequest $request)
    {
        try {

            $data = $request->validated();
            $case = new $this->model();

            $case->beneficiary_name = $data['beneficiary_name'];
            $case->serial_number = Helper::getCaseSerialNumber(); //generate unique number 
            $case->country_id = $data['country_id'];
            $case->status = $data['status'];

            // will saved in parent target or as a relation for this model
            $options = [
                'target' => $request->target,
                "places_ids" => [$request->place_id],
                'admins_ids' => $request->admins_ids
            ];

            $case->save($options);


            return $this->_response($case);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $data = $request->validated();

            $case = $this->model::findOrFail($request->id);

            $case->beneficiary_name = $data['beneficiary_name'];
            $case->country_id = $data['country_id'];
            $case->status = $data['status'];

            //options for parent target
            $options = [
                'target' => $request->target,
                "places_ids" => [$request->place_id],
                'admins_ids' => $request->admins_ids
            ];

            $case->save($options);

            return $this->_response($case);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {
            $cases = $this->model::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('beneficiary_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('serial_number', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString();
            return $this->_response($cases);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list_contents(ListContentRequest $request, Cases $case)
    {

        try {
            return $this->_response(getContent($case, $request));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Cases $case)
    {
        try {
            $data = $request->validated();
            setContent($case, $data['name'], $data['value'], $data['locale']);
            return $this->_response($case->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function list_statuses(Request $request, Cases $case)
    {
        try {
            return $this->_response($case->list_statuses()); // this function exists in baseTargetModel
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_statuses(CreateStatusRequest $request, Cases $case)
    {

        try {
            $data = $request->validated();
            return $this->_response(createStatus($case, $data));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function update_statuses(UpdateStatusRequest $request, Cases $case, Status $status)
    {

        try {

            $data = $request->validated();
            setContent($status, $data['name'], $data['value'], $data['locale']);
            return $this->_response($status);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    /////////////////////// notes  /////////////////////////

    public function listing_notes(Request $request, Cases $case)
    {
        try {
            return $this->_response($case->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_note(CreateNoteRequest $request, Cases $case)
    {
        try {
            $data = $request->validated();

            $note = new Note;
            $note->content = $data['content'];

            $case->notes()->save($note);
            return $this->_response($case->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    public function update_note(UpdateNoteRequest $request, $case_id , Note $note)
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

    public function review_note(UpdateNoteRequest $request, $case_id , Note $note)
    {
        try {
            $user  = auth()->user();
            $exists = $note->reviews()->where('reviewed_by', $user->id)->first();

            if($exists){
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

    public function unreview_note(UpdateNoteRequest $request, $case_id , Note $note)
    {
        try {
            $user  = auth()->user();
            $exists = $note->reviews()->where('reviewed_by', $user->id)->delete();
            return $this->_response($note);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }


    /////////////////////// Card /////////////////////////

    public function listing_cards(Request $request, Cases $case)
    {
        try {
            return $this->_response($case->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_card(CreateCardRequest $request, Cases $case)
    {
        try {
            $data = $request->validated();

            $card = new card;
            $card->name = $data['name'];
            $card->description = $data['description'];

            $case->cards()->save($card);

            return $this->_response($case->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    public function update_card(UpdateCardRequest $request, $case_id, Card $card)
    {
        try {

            $card = Card::findOrFail($request->id);
            $data = $request->validated();

            $card->name = $data['name'];
            $card->description = $data['description'];
            $card->save();

            return $this->_response($card);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function retrieve_card(Request $request, $case_id, Card $card)
    {
        try {
            $card->comments;

            return $this->_response($card);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_comment(CreateCommentRequest $request,  $case_id , Card $card)
    {
        try {
            $data = $request->validated();

            $comment = new Comment();
            $comment->body = $data['body'];

            $card->comments()->save($comment);
            return $this->_response($comment);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    
    public function update_comment(UpdateCommentRequest $request,  $case_id , Card $card)
    {
        try {
            $data = $request->validated();
            $comment = Comment::findOrFail($data['id']);
            $comment->body =  $data['body'];
            $comment->save();

            return $this->_response($comment);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    
    public function delete_comment(Request $request,  $case_id , $card_id , Comment $comment)
    {
        try {

             
            $comment->delete();

            return $this->_response($comment);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    

    /////////////////////// Attachments /////////////////////////

    public function listing_attachments(Request $request, Cases $case)
    {
        try {

            return $this->_response($case->files);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }




    
    
}
