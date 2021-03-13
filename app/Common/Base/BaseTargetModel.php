<?php

namespace App\Common\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 
use App\Models\{Target};
use App\Facades\Helper;
use PDO;

abstract class BaseTargetModel extends Model {
    
    protected $model_path;
    
    const targetAttributes = [
        'required' , 
        'received' ,
        'left' ,
        'left_to_complete' ,
        'spent' ,
        'beneficiaries_count' ,
        'archived' ,
        'documented' ,
        'visible' ,
        'posted' ,
    ];

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
            
            
            // foreach(self::targetAttributes as $item){
            //   if(in_array($item , $options )){
            //       $target->$item = $options[$item];
            //     }
            // }
           
            $target->fill($options);//
            switch (get_class($this)) {
                case "App\Models\Cases":
                    $target = $this->beforeSaveCase($target);
                    break;
                
                default:
                    # code...
                    break; 
            }

            // dd($target);
                        // dd(self::targetAttributes , $options ,$options[$item] , $item , $target);;
            $target->save();
            
            
            $this->target_id = $target->id;
            
            return parent::save();
            
        }else{

            $target = $this->parent;
            
             $target->fill($options);//
             switch (get_class($this)) {
             case "App\Models\Cases":
             $target = $this->beforeSaveCase($target);
             break;

             default:
             # code...
             break;
             }
            
            $target->save();
        }
        
    }

      public function parent()
      {
            return $this->belongsTo('App\Models\Target', 'target_id', 'id');
      }
    

    
    public function delete(array $options = []){
        
        $this->target->delete();
        
        return parent::delete();
        
    }
    
    //return Target
    private function beforeSaveCase(Target $target){

        if(isset($target->category_id)){
            if($target->category_id== 4){
                // طبية 
                $target->section_id = 1 ;
                
            }elseif($target->category_id== 5){
                $target->section_id = 2 ;
                //انسانية
            }
        }

        return $target;
    }
    
}
