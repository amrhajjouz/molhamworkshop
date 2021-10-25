<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\PaymentTransactionService;
use App\Http\Requests\TransactionPayment\CreatePaymentRequest;
use App\Http\Requests\TransactionPayment\TransferTransactionRequest;
use App\Models\PaymentTransaction;
use Exception;

class PaymentTransactionController extends Controller
{
    protected $transactionService;

    public function __construct(PaymentTransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function create(CreatePaymentRequest $request)
    {
        try {
            $this->transactionService->CreateTransaction($request->validated());
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function transfer(TransferTransactionRequest $request)
    {
        try {
            $this->transactionService->TransferTransaction($request->validated());
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($transactionId)
    {
        try {
            $this->transactionService->DeleteTransaction($transactionId);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list($category)
    {
        try {
            switch ($category) {
                case "general_fund":
                case "administrative_support":
                    return $this->processReport($category);
                default:
                    throw new Exception("category $category not supported");
            }
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    private function processReport($category)
    {
        $extraColumns = ["type", "related_to", "purpose_type", "created_by"];
        return PaymentTransaction::with([
            "transactionRelated",
            "donation:id,payment_transaction_id,donor_id,payment_method",
            "donation.donor:id,name,email",
            "creator:id,name,email"])
            ->orderBy('id', 'desc')
            ->getByPurposeType($category)
            ->select(["id", "amount", "notes", "created_at"])
            ->addSelect($extraColumns)
            ->PaginateWithAppends(["created_by_name", "extra_description", "donor_name"])
            ->hidden(["creator", "donation", "transactionRelated", "payment_method"])
            ->hidden($extraColumns);
    }
}
