<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Office extends Model
{
    use HasFactory, Notifiable;
    protected $table = "offices";
    protected $fillable = [
        'name',
        'lat',
        'lng',
    ];
}
