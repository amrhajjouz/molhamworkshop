<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Cases , Place};

class MohamdController extends Controller
{
    //
    //this controller just for test any code

    public function test(Request $request){

        die;
        /////////////////////// Test Morph /////////////////////////
        
        $case = Cases::first();
        $place = Place::first();


        $case->places()->attach([$place->id]);

        dd($case->places , $place->cases);
    }
    
}
