<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Sponsorship\{CreateRequest, UpdateRequest , CreateUpdateContent};

use App\Models\{Sponsorship};

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


    public function list_contents(Request $request, $id)
    {

        try {

            $model = $this->model::findOrFail($id);

            return $this->_response(getContent($model));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, $id)
    {
        try {

            $model = $this->model::find($id);

            setContent($request, $model);

            return $this->_response($model->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }
}
