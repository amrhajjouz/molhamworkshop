<?php

namespace App\Models;

use App\Http\Traits\HasUserstamps;
use App\Http\Traits\HasAppendablePagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    use HasFactory;
    use HasAppendablePagination;
    use HasUserstamps;
    protected $table = "r_receivers";
    protected $fillable = ["country_id", "status", "name"];

    public function getCountryNameAttribute()
    { //todo: try to add this only when it's needed
        return $this->country->name;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function accounts()
    {
        return $this->hasmany(Account::class);
    }

    public function scopeSearchByName($query,$input){
        if($input == null)
            return $query;
        return  $query->where('name', 'like', "%{$input}%");
    }
}
