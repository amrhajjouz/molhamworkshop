<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Exception;

class AccountTypeController extends Controller
{
    public function list()
    {
        try {
            return response()->json(AccountType::all());
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
