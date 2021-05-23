<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Models\{Sponsorship, Status, Note,NoteReview, Card};
use App\Http\Requests\Target\Sponsorship\{
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


class SponsorShipController extends BaseController
{

    use HasRetrieve;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Sponsorship::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();

            $sponsorship = new $this->model();
            $sponsorship->beneficiary_name = $data['beneficiary_name'];
            $sponsorship->beneficiary_birthdate =  $data['beneficiary_birthdate'];
            $sponsorship->country_id = $data['country_id'];
            $sponsorship->sponsored = 0;


            /* 
             *  will saved in parent target or as a relation for this model 
             * places_ids => placeable table
             * array admins_ids => admins table
             * array target => some data for target table (parent)
            */

            $options = [
                'target' => $request->target,
                "places_ids" => [$request->place_id],
                'admins_ids' => $request->admins_ids,
            ];

            $sponsorship->save($options);

            return $this->_response($sponsorship);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());;
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $sponsorship = $this->model::findOrFail($request->id);
            $data = $request->validated();

            $sponsorship->beneficiary_name = $data['beneficiary_name'];
            $sponsorship->beneficiary_birthdate = $data['beneficiary_birthdate'];
            $sponsorship->country_id = $data['country_id'];
            $sponsorship->sponsored = $data['sponsored'];

            /* 
             *  will update data in parent target or as a relation for this model 
             * array admins_ids => admins table
             * array target => some data for target table (parent)
            */

            $options = [
                'target' => $request->target,
                "places_ids" => [$request->place_id],
                'admins_ids' => $request->admins_ids,
            ];


            $sponsorship->save($options);

            return $this->_response($sponsorship);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {
            $search_query = ($request->has('q') ? [['beneficiary_name', 'like', '%' . $request->q . '%']] : null);

            $sponsorships = $this->model::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();

            return $this->_response($sponsorships);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list_sponsors(Request $request, $id)
    {

        try {
            $sponsorship = Sponsorship::findOrFail($id);

            $sponsors = $sponsorship->sponsors()->paginate()->through(function ($sponsor, $key) {
                return $sponsor->transform();
            });

            return $this->_response($sponsors);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list_contents(ListContentRequest $request, Sponsorship $sponsorship)
    {

        try {
            return $this->_response(getContent($sponsorship, $request));
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Sponsorship $sponsorship)
    {
        try {
            $data = $request->validated();
            setContent($sponsorship, $data['name'], $data['value'], $data['locale']);
            return $this->_response($sponsorship->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }


    public function list_statuses(Request $request, Sponsorship $sponsorship)
    {
        try {
            return $this->_response($sponsorship->list_statuses()); // this function exists in baseTargetModel
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_statuses(CreateStatusRequest $request, Sponsorship $sponsorship)
    {

        try {
            $data = $request->validated();
            return $this->_response(createStatus($sponsorship, $data));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function update_statuses(UpdateStatusRequest $request, Sponsorship $sponsorship, Status $status)
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

    public function listing_notes(Request $request, Sponsorship $sponsorship)
    {
        try {
            return $this->_response($sponsorship->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_note(CreateNoteRequest $request, Sponsorship $sponsorship)
    {
        try {
            $data = $request->validated();

            $note = new Note;
            $note->content = $data['content'];

            $sponsorship->notes()->save($note);
            return $this->_response($sponsorship->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function update_note(UpdateNoteRequest $request, $sponsorship_id, Note $note)
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

    public function review_note(ReviewUnReviewRequest $request, $sponsorship_id, Note $note)
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

    public function unreview_note(ReviewUnReviewRequest $request, $sponsorship_id, Note $note)
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

    public function listing_cards(Request $request, Sponsorship $sponsorship)
    {
        try {
            return $this->_response($sponsorship->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_card(CreateCardRequest $request, Sponsorship $sponsorship)
    {
        try {
            $data = $request->validated();

            $card = new card;
            $card->name = $data['name'];
            $card->description = $data['description'];

            $sponsorship->cards()->save($card);

            return $this->_response($sponsorship->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    public function update_card(UpdateCardRequest $request, $sponsorship_id, Card $card)
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
