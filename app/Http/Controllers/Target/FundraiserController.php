<?php

namespace App\Http\Controllers\Target;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Models\{Fundraiser, Status, Note, NoteReview, Card};
use App\Http\Requests\Target\Fundraiser\{
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
};

class FundraiserController extends BaseController
{

    use HasRetrieve;

    public function __construct()
    {

        $this->middleware('auth');
        $this->model = \App\Models\Fundraiser::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();

            $fundraiser = new $this->model();

            $fundraiser->verified = $data['verified'];
            $fundraiser->public_visibility = $data['public_visibility'];
            $fundraiser->donor_id = $data['donor_id'];

            /* 
             *  will saved in parent target or as a relation for this model 
             * array admins_ids => admins table
             * array target => some data for target table (parent)
            */

            $options = [
                'target' => $data['target'],
                'admins_ids' => $request->admins_ids

            ];


            $fundraiser->save($options);

            return $this->_response($fundraiser->transform());
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $fundraiser = $this->model::findOrFail($request->id);

            $data = $request->validated();
            $fundraiser->verified = $data['verified'];
            $fundraiser->public_visibility = $data['public_visibility'];
            $fundraiser->donor_id = $data['donor_id'];



            /* 
             *  will update data in parent target or as a relation for this model 
             * array admins_ids => admins table
             * array target => some data for target table (parent)
            */

            $options = [
                'target' => $request->target,
                'admins_ids' => $request->admins_ids,
            ];

            $fundraiser->save($options);

            return $this->_response($fundraiser->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function list(Request $request)
    {


        try {

            $fundraisers = $this->model::orderBy('id', 'desc')
                ->leftJoin('donors AS D',  'fundraisers.donor_id', 'D.id')
                ->select('fundraisers.*', 'D.name AS donor_name')
                ->where(function ($q) use ($request) {
                    $q->where('D.name', 'like', '%' . $request->q  . '%');
                })->paginate(10)->withQueryString();

            return $this->_response($fundraisers);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    public function list_contents(ListContentRequest $request, Fundraiser $fundraiser)
    {

        try {
            return $this->_response(getContent($fundraiser, $request));
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Fundraiser $fundraiser)
    {
        try {
            $data = $request->validated();
            setContent($fundraiser, $data['name'], $data['value'], $data['locale']);
            return $this->_response($fundraiser->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function list_statuses(Request $request, Fundraiser $fundraiser)
    {
        try {
            return $this->_response($fundraiser->list_statuses()); // this function exists in baseTargetModel
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_statuses(CreateStatusRequest $request, Fundraiser $fundraiser)
    {

        try {
            $data = $request->validated();
            return $this->_response(createStatus($fundraiser, $data));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function update_statuses(UpdateStatusRequest $request, Fundraiser $fundraiser, Status $status)
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

    public function listing_notes(Request $request, Fundraiser $fundraiser)
    {
        try {
            return $this->_response($fundraiser->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_note(CreateNoteRequest $request, Fundraiser $fundraiser)
    {
        try {
            $data = $request->validated();

            $note = new Note;
            $note->content = $data['content'];

            $fundraiser->notes()->save($note);
            return $this->_response($fundraiser->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function update_note(UpdateNoteRequest $request, $fundraiser_id, Note $note)
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

    public function review_note(ReviewUnReviewRequest $request, $fundraiser_id, Note $note)
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

    public function unreview_note(ReviewUnReviewRequest $request, $fundraiser_id, Note $note)
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

    public function listing_cards(Request $request, Fundraiser $fundraiser)
    {
        try {
            return $this->_response($fundraiser->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_card(CreateCardRequest $request, Fundraiser $fundraiser)
    {
        try {
            $data = $request->validated();

            $card = new card;
            $card->name = $data['name'];
            $card->description = $data['description'];

            $fundraiser->cards()->save($card);

            return $this->_response($fundraiser->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    public function update_card(UpdateCardRequest $request, $fundraiser_id, Card $card)
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
}
