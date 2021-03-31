<?php

namespace App\Models;


use App\Common\Base\BaseModel;
use App\Models\{Cases, Country};
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends BaseModel
{
     protected $table = 'admins';
     use SoftDeletes;
     
     // public function purpose(){
     //      // dd($this);
     //      return $this->belongsTo($this->adminable_type::class , 'id' , $this->adminable_id);
     // }


     public function user(){
          return $this->belongsTo('App\Models\User'  , 'user_id' , 'id');
     }
     
     
     // public function getAttributes(){

     //      // $this->attributes['purpose'] = $this->purpose;
     //      return $this->attributes;
     
     // }
     


     // public function transform()
     // {

     //      $object = $this->toArray();
     //      $parent = $this->parent;
     //      $country = $this->country;

     //      if ($parent) {
     //           $parent->parent;
     //      }

     //      unset($this->parent);
     //      return array_merge($object, [
     //           'parent' => $parent,
     //           'country' => $country ? ['name' => $country->name] : null
     //      ]);
     // }


}
