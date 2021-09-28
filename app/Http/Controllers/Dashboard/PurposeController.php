<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Purpose;
use Exception;

class PurposeController extends Controller
{
    public function search()
    {
        try {
            return
                Purpose::searchBy("name", request("q"))
                    ->searchBy("title", request("q"))->with("account:id,default_deduction_ratio_id", "account.defaultDeductionRatio:id,ratio,name->ar as title")
                    ->get()->map(function ($purpose) {
                        return [
                            "id" => $purpose->id,
                            "text" => $purpose->title,
                            "title" => $purpose->title,
                            "name" => $purpose->name,
                            "targetable_type" => $purpose->name,
                            "section_name" => $purpose->section_id,
                            "program_name" => $purpose->program_id,
                            "deductionRatio" => $purpose->account->defaultDeductionRatio
                        ];
                    });
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
