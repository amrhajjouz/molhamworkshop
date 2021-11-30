<?php

namespace App\Models;


class Purpose extends BaseModel
{
    protected $table = 'purposes';
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s' , 'title' => 'json',];
    protected $guarded = [];

    public $timestamps = false;

    public function save($options = [])
    {
        if (!$this->exists) {
            $this->created_at = \Carbon\Carbon::now();
            parent::save($options);
        }
        return parent::save($options);
    }

    public function purposable()
    {
        return $this->morphTo();
    }

    // public function target()
    // {
    //     return $this->belongsTo(Target::class , 'purpose_id' , 'id' );
    // }

}
