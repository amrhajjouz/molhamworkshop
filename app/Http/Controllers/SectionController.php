<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\{User, Section};

class SectionController extends BaseController
{
    use HasList;

    public function __construct()
    {

        $this->model = \App\Models\Section::class;
    }

}
