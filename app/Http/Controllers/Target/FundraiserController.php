<?php

namespace App\Http\Controllers\Target;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Http\Requests\Target\Fundraiser\{CreateRequest, UpdateRequest , CreateUpdateContent , ListContentRequest , CreateStatusRequest , UpdateStatusRequest};
use App\Models\{Fundraiser , Status};

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
                                     ->leftJoin('donors AS D' ,  'fundraisers.donor_id' , 'D.id')
                                     ->select( 'fundraisers.*' , 'D.name AS donor_name')
            ->where(function($q)use($request){
                $q->where('D.name' , 'like' , '%' . $request->q  . '%');
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
}
