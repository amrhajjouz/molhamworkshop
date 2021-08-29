<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected  $guarded = [];
    protected $casts = ['name' => 'json'];
    public $timestamps = false;

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function transform()
    {
        $result =  $this->toArray();
        $result['parent'] = [
            'name' => $this->parent ? $this->parent->toArray()['name'][app()->getLocale()] : null,
        ];
        return $result;
    }
}
