<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Facades\Helper;
use App\Http\Requests\Page\{CreateRequest, UpdateRequest, CreateUpdateContent , ListContentRequest};
use App\Models\{Page};

class PageController extends BaseController
{

    use HasRetrieve;

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Page::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();

            $page = new $this->model();
            $page->url = Helper::formatUrl($data['url'], ' ');

            $page->save();

            return $this->_response($page->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $page = $this->model::findOrFail($request->id);

            $data = $request->validated();
            $page->url = Helper::formatUrl($data['url'], ' ');

            $page->save();


            return $this->_response($page->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function list(Request $request)
    {

        try {
            $search_query = ($request->has('q') ? [['url', 'like', '%' . $request->q . '%']] : null);

            // $pages = $this->model::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();
            $pages = $this->model::orderBy('id', 'desc')
                ->leftJoin('contents AS CAR', function($join){
                    $join->on('pages.id','=' ,'CAR.contentable_id')
                        ->where('CAR.contentable_type', 'App\Models\Page')
                        ->where('CAR.name', 'title')
                        ->where('CAR.locale', 'ar');
                })
                ->leftJoin('contents AS CEN', function($join){
                    $join->on('pages.id','=' ,'CEN.contentable_id')
                        ->where('CEN.contentable_type', 'App\Models\Page')
                        ->where('CEN.name', 'title')
                        ->where('CEN.locale', 'en');
                })
                ->select('CAR.value AS ar_title', 'CEN.value AS en_title', 'pages.*')
                ->where(function ($q) use ($request) {
                    if ($request->has("q")) {
                        // $q->orWhere('CAR.ar_title', 'like', '%' .  $request->q . '%');
                        $q->orWhere('CEN.value', 'like', '%' .  $request->q . '%');
                        $q->orWhere('CAR.value', 'like', '%' .  $request->q . '%');
                    }
                })
                ->paginate(10)
            ->withQueryString();;


            return $this->_response($pages);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list_contents(ListContentRequest $request, Page $page)
    {

        try {
            return $this->_response(getContent($page, $request));
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Page $page)
    {
        try {
            $data = $request->validated();
            setContent($page, $data['name'], $data['value'], $data['locale']);
            return $this->_response($page->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }
}
