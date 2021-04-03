<?php

namespace App\Http\Controllers\Target;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Http\Requests\Target\Fundraiser\{CreateRequest, UpdateRequest};
use App\Models\{Fundraiser};

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
            $search_query = ($request->has('q') ? [['donor_id', 'like', '%' . $request->q . '%']] : null);

            $fundraisers = $this->model::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();

            return $this->_response($fundraisers);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
}
