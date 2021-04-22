<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Faq\{CreateRequest, UpdateRequest , CreateUpdateContent};
use App\Models\{Faq};

class FaqController extends BaseController
{
    use HasRetrieve;

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


    public function update(UpdateRequest $request)
    {
        try {

            $model = $this->model::findOrFail($request->id);
            $data = $request->all();
            $model->category_id = $data['category_id'];
            $model->save();
            return $this->_response($model->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {

            $faqs = $this->model::orderBy('id', 'desc')
                ->join('categories', 'faqs.category_id', 'categories.id')
                ->leftJoin('contents AS CAR', function ($join) {
                    $join->on('faqs.id', '=', 'CAR.contentable_id')
                        ->where('CAR.contentable_type', 'faq')
                        ->where('CAR.name', 'question')
                        ->where('CAR.locale', 'ar')
                        ->where('CAR.deleted_at', null);
                })
                ->leftJoin('contents AS CEN', function ($join) {
                    $join->on('faqs.id', '=', 'CEN.contentable_id')
                        ->where('CEN.contentable_type', 'faq')
                        ->where('CEN.name', 'question')
                        ->where('CEN.locale', 'en')
                        ->where('CEN.deleted_at', null);
                })
                ->select('CAR.value AS ar_question', 'CEN.value AS en_question', 'faqs.*' , 'categories.name as category')
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
