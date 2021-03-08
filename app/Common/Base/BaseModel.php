<?php

namespace App\Common\Base;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model {

    protected $guarded = [];
    
    public static function Table(){
        return with(new static)->getTable();
    }
    
    
    
    public function transform(){
        
        if(isset($this->transformer)){
            $class = $this->transformer;
            return $class::transform($this);
        }
        
        return $this;
    }
    
    public function jsonify($options = []){
        
        return [];
    }
    
}
