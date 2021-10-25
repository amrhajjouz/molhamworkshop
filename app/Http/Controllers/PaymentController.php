<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\PaymentTransactionService;
use App\Models\Payment;
use Exception;

class PaymentController extends Controller
{
    protected $transactionService;

    public function __construct(PaymentTransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function list()
    {
        try {
            return Payment::orderBy('id', 'desc')
                ->with("donor:id,name,email")
                ->select(["id", "amount", "currency", "status", "donor_id", "received_at", "created_at", "notes", "fee"])
                ->PaginateWithAppends(["donor_name"])
                ->hidden(["donor", "donor_id"]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($payment)
    {
        try {
            $this->transactionService->DeletePayment($payment);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
