<?php

namespace App\Models;


use App\Common\Base\BaseModel;

class NoteReview extends BaseModel
{

     protected $table = 'notes_reviews';
     protected $guarded = [];

     public function note(){
          return $this->belongsTo('App\Models\Note' , 'note_id' , 'id');
     }
   
     public function reviewer(){
          return $this->belongsTo('App\Models\User' , 'reviewed_by' , 'id');
     }
     



}
