<?php

namespace App\Models;


class CartItem extends BaseModel
{
    protected $table = 'cart_items';
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s'];
    protected $guarded = [];

    public $timestamps = false;

    public function save($options = []){
        if(!$this->exists){
            $this->created_at = \Carbon\Carbon::now();

            return parent::save($options);
        }
    }
    public function donor()
    {
        return $this->belongsTo('App\Models\Donor');
    }
    
    public function purpose()
    {
        return $this->belongsTo('App\Models\Purpose');
    }

}
