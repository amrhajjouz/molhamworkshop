<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class PurposeController extends Controller
{
    public function search()
    {
        $purposes = collect($this->DemoData());
        $search = request()->q;
        $data = collect($purposes)->filter(function ($item) use ($search) {
            return false !== stristr($item["title"], $search);
        });

        return $data;
    }

    public function DemoData()
    {
        return [[
            'id' => 1,
            'title' => "تبرع عام ",
            'program_name' => "تبرع عام ",
            'account_name' => "تبرع عام ",
            'section_name' => "تبرع عام ",
        ], [
            'id' => 2,
            'title' => "تبرع زكاة",
            'program_name' => "تبرع عام ",
            'account_name' => "تبرع عام ",
            'section_name' => "تبرع عام ",
        ], [
            'id' => 3,
            'title' => "دعم اداري",
            'program_name' => "دعم اداري",
            'account_name' => "دعم اداري",
            'section_name' => "دعم اداري",
        ], [
            'id' => 4,
            'title' => "الحالة 13000",
            'program_name' => "الحالة 13000",
            'account_name' => "الحالة 13000",
            'section_name' => "الحالة 13000",
        ], [
            'id' => 5,
            'title' => "الحملة 300",
            'program_name' => "الحملة 300",
            'account_name' => "الحملة 300",
            'section_name' => "الحملة 300",
        ], [
            'id' => 6,
            'title' => "الكلفالة 150",
            'program_name' => "الكلفالة 150",
            'account_name' => "الكلفالة 150",
            'section_name' => "الكلفالة 150",
        ], [
            'id' => 7,
            'title' => " المنسبة 2000",
            'program_name' => " المنسبة 2000",
            'account_name' => " المنسبة 2000",
            'section_name' => " المنسبة 2000",
        ]];
    }
}
