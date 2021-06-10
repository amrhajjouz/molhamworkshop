<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Models\{Campaign, Status , Note , NoteReview , Card, Comment};
use App\Http\Requests\Target\Campaign\{
    CreateRequest,
    UpdateRequest,
    CreateUpdateContent,
    ListContentRequest,
    CreateStatusRequest,
    UpdateStatusRequest,

    /////////////// Note 
    CreateNoteRequest,
    UpdateNoteRequest,
    ReviewUnReviewRequest,
    /////////////////////// Cards
    CreateCardRequest,
    UpdateCardRequest,
    CreateCommentRequest,
    UpdateCommentRequest,
};

class CampaignController extends BaseController
{

    use HasRetrieve;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Campaign::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();

            $campaign = new $this->model();

            $campaign->name = $data['name'];
            $campaign->funded = 0;

            // will saved in parent target or as a relation for this model
            $options = [
                'target' => $request->target,
                "places_ids" => $request->places_ids,
                'admins_ids' => $request->admins_ids
            ];

            $campaign->save($options);

            return $this->_response($campaign);
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }


    public function update(UpdateRequest $request)
    {

        try {

            $campaign = $this->model::findOrFail($request->id);

            $data = $request->validated();

            $campaign->name = $data['name'];
            $campaign->funded = $data['funded'];

            //used in parent target or another relations
            $options = [
                'target' => $request->target,
                "places_ids" => $request->places_ids,
                'admins_ids' => $request->admins_ids
            ];

            $campaign->save($options);

            return $this->_response($campaign);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function list(Request $request)
    {

        try {
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);

            $campaign = $this->model::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();

            return $this->_response($campaign);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list_contents(ListContentRequest $request, Campaign $campaign)
    {

        try {
            return $this->_response(getContent($campaign, $request));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Campaign $campaign)
    {
        try {
            $data = $request->validated();
            setContent($campaign, $data['name'], $data['value'], $data['locale']);
            return $this->_response($campaign->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }


    public function list_statuses(Request $request, Campaign $campaign)
    {
        try {
            return $this->_response($campaign->list_statuses()); // this function exists in baseTargetModel
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_statuses(CreateStatusRequest $request, Campaign $campaign)
    {

        try {
            $data = $request->validated();
            return $this->_response(createStatus($campaign, $data));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function update_statuses(UpdateStatusRequest $request, $campaign_id, Status $status)
    {

        try {

            $data = $request->validated();
            setContent($status, $data['name'], $data['value'], $data['locale']);
            return $this->_response($status);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }


    /////////////////////// Notes /////////////////////////

    public function listing_notes(Request $request, Campaign $campaign)
    {
        try {
            return $this->_response($campaign->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_note(CreateNoteRequest $request, Campaign $campaign)
    {
        try {
            $data = $request->validated();

            $note = new Note;
            $note->content = $data['content'];

            $campaign->notes()->save($note);
            return $this->_response($campaign->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    
    public function update_note(UpdateNoteRequest $request, $campaign_id, Note $note)
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

    public function review_note(ReviewUnReviewRequest $request, $campaign_id, Note $note)
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

    public function unreview_note(ReviewUnReviewRequest $request, $campaign_id, Note $note)
    {
        try {
            $user  = auth()->user();
            $note->reviews()->where('reviewed_by', $user->id)->delete();
            return $this->_response($note);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }



    /////////////////////// Card /////////////////////////

    public function listing_cards(Request $request, Campaign $campaign)
    {
        try {
            return $this->_response($campaign->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    public function create_card(CreateCardRequest $request, Campaign $campaign)
    {
        try {
            $data = $request->validated();

            $card = new card;
            $card->name = $data['name'];
            $card->description = $data['description'];

            $campaign->cards()->save($card);

            return $this->_response($campaign->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    public function update_card(UpdateCardRequest $request, $campaign_id, Card $card)
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


    public function retrieve_card(Request $request, $campaign_id, Card $card)
    {
        try {
            $card->comments;

            return $this->_response($card);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_comment(CreateCommentRequest $request,  $campaign_id, Card $card)
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

    public function update_comment(UpdateCommentRequest $request,  $campaign_id, Card $card)
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

    public function delete_comment(Request $request,  $campaign_id, $card_id, Comment $comment)
    {
        try {


            $comment->delete();

            return $this->_response($comment);
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }





}
