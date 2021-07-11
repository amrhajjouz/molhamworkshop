<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{

     protected $table = 'files';
     protected $guarded = [];



     public function fileable()
     {
          return $this->morphTo();
     }


     public function save($options = []){

          $is_new = !$this->exists;
          $ret = null;
          
          if($is_new){
              
               if(!$this->reference){
                    $reference = Str::random(10) . '.' . $this->extension;
                    do {
                         $reference = Str::random(10) . '.' . $this->extension;
                    } while (self::where('reference', $reference)->exists());
                    $this->reference = $reference;
               }
               
               $ret =  parent::save($options);
          }else{
               $ret =  parent::save($options);
               
          }
          
          return $ret;
           

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
