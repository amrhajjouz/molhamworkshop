<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Campaign\{CreateRequest, UpdateRequest, CreateUpdateContent, ListContentRequest, CreateStatusRequest, UpdateStatusRequest};
use App\Models\{Campaign, Status};

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
}
