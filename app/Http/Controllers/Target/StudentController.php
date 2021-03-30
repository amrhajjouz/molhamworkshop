<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Student\{CreateRequest, UpdateRequest};

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
            $options = ['target' => $request->target, "places_ids" => [$request->place_id]]; //used in parent target

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
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);

            $students = $this->model::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();

            return $this->_response($students);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }




    public function list_sponsors(Request $request, $id)
    {

        try {
            $student = Student::findOrFail($id);

            $sponsors = $student->sponsors()->paginate()->through(function ($sponsor, $key) {
                return $sponsor->transform();
            });

            return $this->_response($sponsors);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
}
