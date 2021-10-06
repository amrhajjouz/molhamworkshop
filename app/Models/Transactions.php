<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable= ["amount", "currency", "fx_rate", "method", "account_id", "section_id", "program_id", "related_to"];
}
