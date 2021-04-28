<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Cases\{CreateRequest, UpdateRequest, CreateUpdateContent, ListContentRequest , CreateStatusRequest , UpdateStatusRequest};
use App\Facades\Helper;
use App\Models\{Cases , Status};

class CaseController extends BaseController
{

    use HasRetrieve;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Cases::class;
    }

    public function create(CreateRequest $request)
    {
        try {

            $data = $request->validated();
            $case = new $this->model();

            $case->beneficiary_name = $data['beneficiary_name'];
            $case->serial_number = Helper::getCaseSerialNumber(); //generate unique number 
            $case->country_id = $data['country_id'];
            $case->status = $data['status'];

            $options = ['target' => $request->target, "places_ids" => [$request->place_id], 'admins_ids' => $request->admins_ids]; // will saved in parent target or as a relation for this model
            $case->save($options);


            return $this->_response($case);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $data = $request->validated();

            $case = $this->model::findOrFail($request->id);

            $case->beneficiary_name = $data['beneficiary_name'];
            $case->country_id = $data['country_id'];
            $case->status = $data['status'];

            $options = ['target' => $request->target, "places_ids" => [$request->place_id], 'admins_ids' => $request->admins_ids]; //options for parent target


            $case->save($options);

            return $this->_response($case);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {
            $cases = $this->model::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('beneficiary_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('serial_number', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString();
            return $this->_response($cases);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list_contents(ListContentRequest $request, Cases $case)
    {

        try {
            return $this->_response(getContent($case, $request));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Cases $case)
    {
        try {
            $data = $request->validated();
            setContent($case, $data['name'], $data['value'], $data['locale']);
            return $this->_response($case->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function list_statuses(Request $request, Cases $case)
    {
        try {
            return $this->_response($case->list_statuses()); // this function exists in baseTargetModel
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
   
    public function create_statuses(CreateStatusRequest $request, Cases $case)
    {

        try {
            $data = $request->validated();
            return $this->_response(createStatus($case , $data));
        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
   
    public function update_statuses(UpdateStatusRequest $request, Cases $case , Status $status )
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
