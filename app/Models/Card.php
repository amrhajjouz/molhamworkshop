<?php

namespace App\Models;


use App\Common\Base\BaseModel;

class Card extends BaseModel
{

     protected $table = 'cards';
     protected $guarded = [];



     public function cardable()
     {
          return $this->morphTo();
     }


     public function save($options = []){

          $is_new = !$this->exists;

          
          if($is_new){
          }else{
               $this->updated_by = auth()->id();
               
          }
          
          return parent::save($options);
           

     }
     


     public function transform()
     {

          $card = $this->toArray();

          return (object)array_merge($card, [
               'creator' => $this->creator,
               'updator' => $this->updator,
          ]);
     }


    
     

}
