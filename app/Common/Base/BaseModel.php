<?php

namespace App\Common\Base;

use Illuminate\Database\Eloquent\Model;

 class BaseModel extends Model {

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

    /* 
     * return who create this record if record has created_by field 
    */

    public function creator(){
        return $this->hasOne('App\Models\User' , 'id' , 'created_by');
    }
    

    public function save(array $options = []){
        
        // dd($this->exists , $this->hasAttribute('created_by') , $this->attributes , \Schema::hasColumn($this->getTable(), "created_by") , $this->getTable());

        if(!$this->exists && $this->hasColumn('created_by')){
            $this->created_by = auth()->id();
            // dd(1);
        }

        return parent::save($options);
        
    }


    /* 
     *  check if any model has specific column
    */

    public function hasColumn($attr)
    {
        return \Schema::hasColumn($this->getTable(), $attr);
    }
    
}
