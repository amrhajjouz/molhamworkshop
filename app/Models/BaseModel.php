<?php

namespace App\Models;

use App\Http\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasUserstamps;
}
