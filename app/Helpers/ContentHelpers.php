<?php

use App\Models\Content;



/* 
 * Get Contents records for any data model has relation pivot with Content model 
*/
function getContent($contentable , $request)
{
    $locales = config('general.available_locales');

    /* 
     * this static function comes from contaentable model  
    */

    $required_contents_fields = $contentable::get_content_fields();

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
    $contentable_type = get_class($contentable);



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
    ]);
}



/*
 * Set Contents records for any data model has relation pivot with Content model 
*/
// function setContent($data, $contentable)
// {

//     $locales = config('general.available_locales');


//     /* 
//      * this static function comes from contaentable model  
//     */

//     $required_contents_fields = $contentable::get_content_fields();

//     // $data = $request->validated();


//     // if we have contents as array inside object in request 
//     if (isset($data['contents'])) {
//         $data = $data['contents'];
//     }


//     foreach ($data as $name => $values) {

//         /* 
//         * if there is any value not registerd in constructor dont save it
//         */
//         if (!in_array($name, $required_contents_fields)) continue;


//         // TODO:CHECK IF IS ARRAY AND IF MULTIPLE 
//         // TODO:IF SINGLE DELETE ALL AND CREATE


//         foreach ($values  as $locale => $value) {
//             /* 
//                  * if value equal null dont create new record  
//                 */
//             if (is_null($value)) continue;


//             \App\Models\Content::where('contentable_type' ,get_class($contentable))
//                                ->where('contentable_id' , $contentable->id)
//                                ->where('name' , $name)
//                                ->where('locale' , $locale)
//                                ->delete();


//             \App\Models\Content::Create(
//                 [
//                     'contentable_type' => get_class($contentable),
//                     'contentable_id' => $contentable->id,
//                     'locale' => $locale, 'name' => $name,
//                     'value' => $value,
//                 ]
//             );
//         }
//     }
//     return true;
// }







// TEST Function 


function setSingleContent($contentable , Content $content){
    
    // if(!$content->id) return false;
    if(!$contentable->id) return false;

    /* 
     * check if exists and delete
    */

    Content::where('id' , $content->id)->delete();
    
    $new_content = new Content;

    $new_content -> name = $content->name;
    $new_content -> value = $content->value;
    $new_content -> contentable_id = $contentable->id;
    $new_content -> contentable_type = get_class($contentable);
    
    $new_content->save();

    return $new_content;


}









