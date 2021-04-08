<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList, HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Faq\{CreateRequest, UpdateRequest};
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
            // dd($request->validated());
            $faq->save();
            setContent($request, $faq);
            // unset($data['category_id']);

            // foreach($data  as $locales){
            //     foreach($locales  as $_content){
            //         $content = new Content();
            //         $content->name = $_content['name'];
            //         $content->value = $_content['value'];
            //         $content->locale = $_content['locale'];
            //         $content->contentable_type = 'App\Models\Faq';
            //         $content->contentable_id= $faq->id;
                    
            //         $content->save();
                    
            //     }
            // }

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
            setContent($request, $model);

            return $this->_response($model->contents);
        } catch (\Exception $ex) {
            throw $this->_exception($ex->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {

            $faqs = $this->model::orderBy('id', 'desc')
                ->join('contents', 'faqs.id', 'contents.contentable_id')
                ->join('categories', 'faqs.category_id', 'categories.id')
                ->where('contents.contentable_type', 'App\Models\Faq')
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




}
