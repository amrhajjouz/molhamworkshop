<?php

use App\Models\Content;

/* 
 * Get Contents records for any data model has relation pivot with Content model 
*/
function getContent($contentable , $request = null)
{

    /* 
     * if request null get request from helper function 
    */
    if(is_null($request)) $request = request();



    $locales = config('general.available_locales');

    /* 
     * this static function comes from contaentable model  
    */

    $required_contents_fields = $contentable::get_content_fields();

    if(in_array('*' , $required_contents_fields)){
         $required_contents_fields = [];
        $fields = $contentable->contents()->get('name')->toArray();
        foreach($fields  as $field){
            $required_contents_fields [] = $field['name'];
        }
    }

    /* 
     * if isset only one field in routes like ?field=foo 
    */
    if(isset($request->field)){
        $required_contents_fields = [$request->field];
    }


    $contents = $contentable->contents()->where(function($q)use($request){

        if(isset($request->field)){
            $q->where('name' , $request->field);
        }
       
    });

    if (isset($request->trashed) && $request->trashed == "true") {
        return $contents = $contents->withTrashed()->get();
    }else{
        $contents = $contents->get();
    }
    
    $content = [];
    foreach ($required_contents_fields as $name => $field) {
        foreach ($locales as $l) {
            $content[is_array($field) ? $name : $field][$l] = null;
        }
    }

    foreach ($contents as $c) {

        /* 
        * if there any value not required dont display it 
        */

        if (!in_array($c->name, $required_contents_fields)) continue;

        $content[$c->name][$c->locale] = $c->value;
    }


    return $content;
}

function setContent($contentable, $name, $value, $locale = 'ar')
{
    $contentable_id = $contentable->id;

    $arr = explode("\\", get_class($contentable));

    // $contentable_type = get_class($contentable);
    $contentable_type = strtolower(array_pop($arr));

    /* 
     * For delete Before create  
    */
    Content::where('name', $name)
        ->where('contentable_id', $contentable_id)
        ->where('contentable_type', $contentable_type)
        ->where('locale', $locale)
        ->delete();


    return Content::create([
        'name' => $name,
        'value' => $value,
        'contentable_id' => $contentable_id,
        'contentable_type' => $contentable_type,
        'locale' => $locale,
    ]);
}



