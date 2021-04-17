<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Student\{CreateRequest, UpdateRequest , CreateUpdateContent , ListContentRequest};

use App\Models\{Student};

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
            $options = ['target' => $request->target, "places_ids" => [$request->place_id], 'admins_ids' => $request->admins_ids]; // will saved in parent target or as a relation for this model

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

            $options = ['target' => $request->target, "places_ids" => [$request->place_id], 'admins_ids' => $request->admins_ids]; //used in parent target or another relations

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
    public function list_contents(ListContentRequest $request, Student $student)
    {

        try {
            return $this->_response(getContent($student, $request));
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Student $student)
    {
        try {
            $data = $request->validated();
            setContent($student, $data['name'], $data['value'], $data['locale']);
            return $this->_response($student->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }
}
