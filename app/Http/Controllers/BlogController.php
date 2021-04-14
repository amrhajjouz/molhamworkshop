<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Facades\Helper;
use App\Http\Requests\Blog\{CreateRequest, UpdateRequest, CreateUpdateContent};

class BlogController extends BaseController
{

    use HasRetrieve;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Blog::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();

            $blog = new $this->model();
            $blog->url = Helper::formatUrl($data['url'] , ' ');

            $blog->save();

            return $this->_response($blog->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $blog = $this->model::findOrFail($request->id);

            $data = $request->validated();
            $blog->url = Helper::formatUrl($data['url'] , ' ');

            $blog->save();


            return $this->_response($blog->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function list(Request $request)
    {

        try {
            $search_query = ($request->has('q') ? [['url', 'like', '%' . $request->q . '%']] : null);

            $events = $this->model::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();

            return $this->_response($events);
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

            setContent($request->validated(), $model);

            return $this->_response($model->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }


  
}
