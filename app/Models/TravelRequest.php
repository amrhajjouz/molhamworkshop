<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use DateTime;

class TravelRequest extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at','start_date','end_date'];

    protected $casts = [
        'start_date'  => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    protected $appends = ['days'];

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getDaysAttribute() {
        $fdate = $this->start_date;
        $tdate = $this->end_date;
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');//now do whatever you like with $days
        return $days;
    }
}
