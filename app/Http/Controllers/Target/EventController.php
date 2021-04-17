<?php

namespace App\Http\Controllers\Target;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Http\Requests\Target\Event\{CreateRequest, UpdateRequest , CreateUpdateContent , ListContentRequest};
use App\Models\{Event};

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

            if ($data['implementation_date']) {
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
                 "places_ids" => $request->places_ids ,
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
    
}
