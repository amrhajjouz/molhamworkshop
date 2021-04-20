<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList, HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Faq\{CreateRequest, UpdateRequest  , ListContentRequest , CreateUpdateContent};
use App\Models\{User, Faq, Content};
use App\Facades\Helper;

class FaqController extends BaseController
{
    use HasList, HasRetrieve;

    public function __construct()
    {
        $this->model = \App\Models\Faq::class;
    }

    public function create(CreateRequest $request)
    {
        try {

            $data = $request->validated();
            $faq = new $this->model();
            $faq->category_id  = $data['category_id'];
            $faq->save();

            foreach ($data['contents']  as $content) {
                setContent($faq, $content['name'], $content['value'], 'ar');
            }


            return $this->_response($faq);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    // public function update(UpdateRequest $request)
    // {
    //     try {

    //         $model = $this->model::findOrFail($request->id);
    //         $data = $request->all();
    //         $model->category_id = $data['category_id'];
    //         $model->save();
    //         setContent($request->all(), $model);

    //         return $this->_response($model->contents);
    //     } catch (\Exception $ex) {
    //         throw $this->_exception($ex->getMessage());
    //     }
    // }

    public function list(Request $request)
    {

        try {

            $faqs = $this->model::orderBy('id', 'desc')
                ->join('contents', 'faqs.id', 'contents.contentable_id')
                ->join('categories', 'faqs.category_id', 'categories.id')
                ->where('contents.contentable_type', 'App\Models\Faq')
                ->where('contents.deleted_at', null)
                ->select('contents.value', 'contents.name', 'contents.locale', 'faqs.*' , 'categories.name as category')
                ->where(function ($q) use ($request) {
                    if ($request->has("q")) {
                        $q->where('contents.name', 'like', '%' .$request-> q . '%');
                        $q->orWhere('contents.value', 'like', '%' .  $request->q . '%');
                        $q->orWhere('categories.name', 'like', '%' .  $request->q . '%');
                    }
                })
                ->paginate(10)
                ->withQueryString();

            return $this->_response($faqs);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    public function list_contents(ListContentRequest $request, Faq $faq)
    {

        try {
            return $this->_response(getContent($faq, $request));
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function create_update_contents(CreateUpdateContent $request, Faq $faq)
    {
        try {
            $data = $request->validated();
            setContent($faq, $data['name'], $data['value'], $data['locale']);
            return $this->_response($faq->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }



}
