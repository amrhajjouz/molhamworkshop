<?php

namespace App\Models;


use App\Common\Base\BaseModel;

class Note extends BaseModel
{

     protected $table = 'notes';
     protected $guarded = [];



     public function noteable()
     {
          return $this->morphTo();
     }

     public function reviews(){
          return $this->hasMany('App\Models\NoteReview' , 'note_id' , 'id');
     }


     public function transform_reviews(){
          $response = [];

          foreach($this->reviews  as $review){
               $response[] = $review->reviewer;
          }

          return $response;

     }
     


     public function transform()
     {

          $shortcut = $this->toArray();

          return (object)array_merge($shortcut, [
               'reviews' => $this->reviews,
          ]);
     }


     // public function save($options = []){
          
     //      $this->created_by = auth()->id();

     //      return parent::save($options);
     // }
     

}
