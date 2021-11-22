<?php

namespace App\Models;


class Purpose extends BaseModel
{
    protected $table = 'purposes';
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s'];
    protected $guarded = [];

    public $timestamps = false;

    public function save($options = [])
    {
        if (!$this->exists) {
            $this->created_at = \Carbon\Carbon::now();

            return parent::save($options);
        }
    }

    public function purposable()
    {
        return $this->morphTo();
    }
}
