<?php

namespace App\Http\Controllers\Target;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Http\Requests\Target\Event\{CreateRequest, UpdateRequest};
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
            $options = ['target' => $request->target, "places_ids" => $request->places_ids];

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

            $options = ['target' => $request->target, "places_ids" => $request->places_ids];

            $event->save($options);

            return $this->_response($event->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {
            $result = [];
            $data = $this->model::all();


            return response()->json($data);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }   
    }
}
