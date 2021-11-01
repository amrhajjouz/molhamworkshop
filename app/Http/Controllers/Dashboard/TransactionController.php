<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\{ListPaymentRequest};
use App\Models\Account;
use App\Models\Transaction;
use Exception;

class TransactionController extends Controller
{
    public function list($accountId)
    {
        try {
            return Transaction::orderBy('id', 'desc')
                ->where("account_id", $accountId)
                ->with("program:id,name","section:id,name","journal:id,journalable_type")
                ->select(["id", "amount", "currency", "fx_rate", "program_id", "section_id", "journal_id"])
                ->PaginateWithAppends(["section_name","program_name","usd_amount","journal_type"])
                ->hidden(["program", "section","program_id", "section_id", "journal"]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
