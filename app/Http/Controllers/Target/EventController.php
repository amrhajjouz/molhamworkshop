<?php

namespace App\Http\Controllers\Target;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Models\{Event, Status ,  Note ,NoteReview, Card};

use App\Http\Requests\Target\Event\{
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

class EventController extends BaseController
{
    use HasRetrieve;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Event::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();

            $event = new $this->model();
            $event->date = date('Y/m/d', strtotime($data['date']));
            $event->verified = $data['verified'];
            $event->public_visibility = $data['public_visibility'];
            $event->implemented = $data['implemented'];
            $event->donor_id = $data['donor_id'];

            if ($data['implemented'] && $data['implementation_date']) {
                $event->implementation_date = date('Y/m/d', strtotime($data['implementation_date']));
            }
            $event->youtube_video_url = $data['youtube_video_url'];


            /* 
             *  will saved in parent target or as a relation for this model 
             * places_ids => placeable table
             * array admins_ids => admins table
             * array target => some data for target table (parent)
            */

            $options = [
                'target' => $request->target,
                "places_ids" => $request->places_ids,
                'admins_ids' => $request->admins_ids
            ];

            $event->save($options);

            return $this->_response($event->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $event = $this->model::findOrFail($request->id);

            $data = $request->validated();
            $event->date = date('Y/m/d', strtotime($data['date']));
            $event->verified = $data['verified'];
            $event->public_visibility = $data['public_visibility'];
            $event->implemented = $data['implemented'];
            $event->donor_id = $data['donor_id'];

            if ($data['implementation_date']) {
                $event->implementation_date = date('Y/m/d', strtotime($data['implementation_date']));
            }
            $event->youtube_video_url = $data['youtube_video_url'];



            /* 
             *  will update data in parent target or as a relation for this model 
             * array places_ids => placeable table
             * array admins_ids => admins table
             * array target => some data for target table (parent)
            */
            $options = [
                'target' => $request->target,
                "places_ids" => $request->places_ids,
                'admins_ids' => $request->admins_ids,
            ];

            $event->save($options);

            return $this->_response($event->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {
            $search_query = ($request->has('q') ? [['donor_id', 'like', '%' . $request->q . '%']] : null);

            $events = $this->model::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();

            return $this->_response($events);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    public function list_contents(ListContentRequest $request, Event $event)
    {

        try {
            return $this->_response(getContent($event, $request));
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Event $event)
    {
        try {
            $data = $request->validated();
            setContent($event, $data['name'], $data['value'], $data['locale']);
            return $this->_response($event->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }


    public function list_statuses(Request $request, Event $event)
    {
        try {
            return $this->_response($event->list_statuses()); // this function exists in baseTargetModel
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_statuses(CreateStatusRequest $request, Event $event)
    {

        try {
            $data = $request->validated();
            return $this->_response(createStatus($event, $data));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function update_statuses(UpdateStatusRequest $request, Event $event, Status $status)
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

    public function listing_notes(Request $request, Event $event)
    {
        try {
            return $this->_response($event->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_note(CreateNoteRequest $request, Event $event)
    {
        try {
            $data = $request->validated();

            $note = new Note;
            $note->content = $data['content'];

            $event->notes()->save($note);
            return $this->_response($event->listing_notes());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function update_note(UpdateNoteRequest $request, $event_id, Note $note)
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

    public function review_note(ReviewUnReviewRequest $request, $event_id, Note $note)
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

    public function unreview_note(ReviewUnReviewRequest $request, $event_id, Note $note)
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

    public function listing_cards(Request $request, Event $event)
    {
        try {
            return $this->_response($event->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_card(CreateCardRequest $request, Event $event)
    {
        try {
            $data = $request->validated();

            $card = new card;
            $card->name = $data['name'];
            $card->description = $data['description'];

            $event->cards()->save($card);

            return $this->_response($event->listing_cards());
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    public function update_card(UpdateCardRequest $request, $event_id, Card $card)
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
