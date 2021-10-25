<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\PayoutService;
use App\Models\Account;
use App\Models\Agreement;
use App\Models\PayoutRequest;
use App\Models\Voucher;
use Exception;

class VoucherController extends Controller
{
    protected $payoutService;

    public function __construct(PayoutService $payoutService)
    {
        $this->payoutService = $payoutService;
    }

    public function create()
    {
        try {
            $voucher = Voucher::where("payout_request_id", request()->payoutRequestId);

            if ($voucher->exists()) {
                $data["id"] = $voucher->first()->id;
                return response()->json($data);
            }

            $account = Account::find(request()->account_id);

            $payoutRequest = PayoutRequest::whereId(request()->payoutRequestId)->first();

            if ($account->currency != $payoutRequest->currency) {
                throw new Exception("The currency and the selected account are not matched");
            }

            if ($payoutRequest->status != "approved") {
                throw new Exception("You don't have the right to create Voucher for none approved request");
            }

            $voucher = $payoutRequest->voucher()->create([
                "amount" => $payoutRequest->amount,
                "payout_request_id" => $payoutRequest->id,
                "currency" => $payoutRequest->currency,
                "purpose_type" => $payoutRequest->purpose_type,
                "purpose_id" => $payoutRequest->purpose_id,
                "assignee_id" => $payoutRequest->assignee_id,
                "details" => $payoutRequest->details,
                "country_id" => $payoutRequest->country_id,
                "account_id" => request()->account_id,
            ]);

            $data["id"] = $voucher->id;

            return response()->json($data);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus($voucherId)
    {
        try {
            $voucher = Voucher::find($voucherId);

            $data = array(
                "delivered_at" => $voucher->delivered_at,
                "spent_at" => $voucher->spent_at,
            );

            if (request()->has('spent_at') && $voucher->spent_at == null) {
                $data["spent_at"] = now();
                $this->payoutService->createPayoutPayment($voucher);
            }

            if (request()->has('delivered_at') && $voucher->delivered_at == null && $voucher->spent_at != null) {
                $data["delivered_at"] = now();
            }

            $voucher->update($data);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list()
    {
        try {
            $extraColumns = ["country_id", "purpose_type", "assignee_id", "account_id"];
            return Voucher::with([
                "country:id,name",
                "account:id,name,email",
                "assignee:id,name,email",
                "creator:id,name,email"])
                ->orderBy('id', 'desc')
                ->select(["id", "amount", "currency", "created_at", "details", "delivered_at", "spent_at"])
                ->addSelect($extraColumns)
                ->PaginateWithAppends(["country_name", "transaction_purpose_name"])
                ->hidden(["creator", "country"])
                ->hidden($extraColumns);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function search()
    {
        try {
            $currency = null;

            if (request()->matchWithAgreementCurrency == true && request()->has("agreementId")) {
                $agreement = Agreement::whereId(request()->agreementId)->select("currency")->firstOrFail();
                $currency = $agreement->currency;
            }

            return Voucher::SearchByCurrency($currency)
                ->searchById(request()->q)
                ->withoutAgreement()
                ->OnlyCompleted()
                ->select("id", "agreement_id", "currency", "amount")->get()
                ->map(function ($voucher) {
                    return [
                        "id" => $voucher->id,
                        "text" => "[$voucher->id] ($voucher->amount $voucher->currency)"
                    ];
                });
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
