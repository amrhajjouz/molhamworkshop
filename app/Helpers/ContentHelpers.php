<?php



/* 
 * Get Contents records for any data model has relation pivot with Content model 
*/
function getContent($contentable)
{
    $locales = config('general.available_locales');


    /* 
     * this static function comes from contaentable model  
    */

    $required_contents_fields = $contentable::get_content_fields();

    $contents = $contentable->contents;

    $content = [];
    foreach ($required_contents_fields as $field) {
        foreach ($locales as $l) {
            $content[$field][$l] = null;
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



/*
 * Set Contents records for any data model has relation pivot with Content model 
*/
function setContent($request, $contentable )
{

    $locales = config('general.available_locales');


    /* 
     * this static function comes from contaentable model  
    */

    $required_contents_fields = $contentable::get_content_fields();

    $data = $request->validated();


    // if we have contents as array inside object in request 
    if(isset($request->validated()['contents'])){
        $data = $request->validated()['contents']; 
    }


    foreach ($data as $title => $values) {

        /* 
             * if there is any value not registerd in constructor dont save it
            */
        if (!in_array($title, $required_contents_fields)) continue;


        foreach ($values  as $locale => $val) {

            /* 
                 * if value equal null dont create new record  
                */
            if (is_null($val)) continue;

            \App\Models\Content::updateOrCreate(
                ['contentable_type' => get_class($contentable), 'contentable_id' => $contentable->id, 'locale' => $locale, 'name' => $title],
                ['value' => $val]
            );
        }
    }
    return true;
}
