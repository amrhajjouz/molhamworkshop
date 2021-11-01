<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Exception;

class DonationController extends Controller
{
    public function list()
    {
        try {
            $extraColumns = ["donor_id", "country_code"];

            return Donation::orderBy('id', 'desc')
                ->with("donor:id,name,email", "country:code,name")
                ->select(["fee", "amount","usd_amount", "program_id", "section_id","purpose_id", "currency", "method", "received_at", "created_at"])
                ->addSelect($extraColumns)
                ->PaginateWithAppends(["donor_name", "country_name"])
                ->hidden(["donor", "country"])
                ->hidden($extraColumns);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
