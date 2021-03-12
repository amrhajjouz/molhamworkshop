<?php

namespace App\Common\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 
use App\Models\{Target};
use App\Facades\Helper;

abstract class BaseTargetModel extends Model {
    
    protected $model_path;
    
    // abstract function target();
    
    public static function Table(){
        return with(new static)->getTable();
    }
    
    // public function transform(){
        
    //     if(isset($this->transformer)){
    //         $class = $this->transformer;
    //         return $class::transform($this);
    //     }
        
    //     return $this;
    // }
    
    // public function getModelTypeAttribute(){
    //     $rec = \App\Models\ModelLevel::where('name',self::Table())
    //             ->first();
    //     return $rec;
    // }
    
    
    
    public function save(array $options = []){
        $newRecord = ! ( $this->exists );

        if($this->target){
            unset($this->target);
        }

        parent::save($options);
        
        if($newRecord){
            
            // Create Target 
            $reference = Helper::generateRandomString(15);
            
            do {
                $reference = Helper::generateRandomString(15);
            } while (Target::where('reference' , $reference)->exists());
            

            
            
           $target = new \App\Models\Target();
            
           $target->purpose_id = $this->id;

           if(isset($this->model_path)){
               $target->purpose_type = $this->model_path;
           }else{
               $target->purpose_type = self::Table();
           }
           $target->reference = $reference;
         
           if(isset($options["required"])){
               $target->required = $options["required"];
           }
           
           $target->save();
            
           
            $this->target_id = $target->id;
            
            return parent::save();
            
        }else{

            $target = $this->parent;
            
            if(isset($options["required"])){
                $target->required = $options["required"];
            }
            
            $target->save();
        }
        
    }
    
    public function delete(array $options = []){
        
        $this->target->delete();
        
        return parent::delete();
        
    }
    
    
}
