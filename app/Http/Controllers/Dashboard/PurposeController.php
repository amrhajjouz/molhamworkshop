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
            return Purpose::searchBy("name", request("q"))
                ->searchBy("title", request("q"))
                ->with("section:id,name",
                    "program:id,name",
                    "account:id,name,currency,default_deduction_ratio_id",
                    "account.defaultDeductionRatio:id,ratio,name->ar as title")
                ->get()
                ->map(function ($purpose) {
                    return [
                        "id" => $purpose->id,
                        "text" => $purpose->title,
                        "title" => $purpose->title,
                        "name" => $purpose->name,
                        "account_name" => $purpose->account->name[app()->getlocale()],
                        "account_currency" => $purpose->account->currency,
                        "targetable_type" => $purpose->name,
                        "section_name" => $purpose->section->name[app()->getlocale()],
                        "program_name" => $purpose->program->name[app()->getlocale()],
                        "deductionRatio" => $purpose->account->defaultDeductionRatio
                    ];
                });
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
