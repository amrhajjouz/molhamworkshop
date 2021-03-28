<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Student\{CreateRequest, UpdateRequest};
use App\Facades\Helper;

use App\Models\{User, Student};

class StudentController extends BaseController
{

    use HasRetrieve;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Student::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();
            $student = new $this->model();
            $student->name = $data['name'];
            $student->country_id = $data['country_id'];
            $student->semesters_count = $data['semesters_count'];
            $student->current_semester = $data['current_semester'];
            $options = ['target' => $request->target, "places_ids" => [$request->place_id]];

            $student->save($options);


            return $this->_response($student);
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $student = $this->model::findOrFail($request->id);

            $data = $request->validated();
            $student->name = $data['name'];
            $student->country_id = $data['country_id'];
            $student->semesters_count = $data['semesters_count'];
            $student->current_semester = $data['current_semester'];

            $options = ['target' => $request->target, "places_ids" => [$request->place_id]];

            $student->save($options);

            return $this->_response($student->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {
            $result = [];
            $data = $this->model::all();

            foreach ($data as $student) {
                $result[] = $student->transform();
            }

            return $this->_response($result);
        } catch (\Exception $e) {

            return ['error' => $e->getMessage()];
        }
    }


    public function list_sponsors(Request $request, $id)
    {

        try {

            $object = $this->model::findOrFail($id);

            $sponsors = $object->sponsors;

            $res = [];
            foreach ($sponsors  as $item) {
                $res[] = $item->transform();
            }

            return $this->_response($res);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
}
