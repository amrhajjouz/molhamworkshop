<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Exception;

class DonationController extends Controller
{
    public function list()
    {
        try {
            $extraColumns = ["donor_id", "country_id"];

            return Donation::orderBy('id', 'desc')
                ->with("donor:id,name,email", "country:id,name", "creator:id,name,email")
                ->select(["fee", "amount", "currency", "payment_method", "received_at", "created_at", "locale"])
                ->addSelect($extraColumns)
                ->PaginateWithAppends(["donor_name", "country_name"])
                ->hidden(["donor", "country"])
                ->hidden($extraColumns);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
