<?php

namespace App\Models;

class Country extends BaseModel
{
    const UPDATED_BY = null;
    const CREATED_BY = null;
    public $timestamps = false;
    protected $table = "countries";
    protected $guarded = [];
    protected $casts = ['name' => 'json', 'nationality' => 'json'];
}
