<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use Exception;

class PayoutController extends Controller
{
    public function list()
    {
        try {
            return Payout::orderBy('id', 'desc')
                ->with("country:id,name", "voucher:id,purpose_type")
                ->select(["id", "amount", "currency", "created_at", "country_id", "payout_voucher_id"])
                ->PaginateWithAppends(["country_name", "purpose_name"])
                ->hidden(["country", "country_id", "voucher", "payout_voucher_id"]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
