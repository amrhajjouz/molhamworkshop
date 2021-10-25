<?php

namespace App\Http\Controllers;

use Exception;

class LanguageController extends Controller
{
    public function list()
    {
        try {
            $languages = config('app.locales');
            return array_map(function ($code, $name) {
                return array(
                    'code' => $code,
                    'name' => $name
                );
            }, array_keys($languages), $languages);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
