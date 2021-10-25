<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\PayoutService;
use App\Http\Requests\Payout\CreatePayoutRequest;
use App\Http\Requests\Payout\CreatePayoutRequestReview;
use App\Models\PayoutRequest;
use App\Models\PayoutRequestReviews;
use Exception;

class PayoutRequestController extends Controller
{
    protected $payoutService;

    public function __construct(PayoutService $payoutService)
    {
        $this->payoutService = $payoutService;
    }

    public function create(CreatePayoutRequest $request)
    {
        try {
            $this->payoutService->CreatePayoutRequest($request->validated());
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list()
    {
        try {
            $extraColumns = ["country_id", "next_review_id", "purpose_type"];
            return PayoutRequest::with([
                "voucher:id",
                "country:id,name",
                "nextPaymentRequestReview:id,required_role",
                "creator:id,name,email"])
                ->orderBy('id', 'desc')
                ->select(["id", "amount", "currency", "created_at", "details", "status"])
                ->addSelect($extraColumns)
                ->PaginateWithAppends(["next_review_name", "has_voucher", "country_name", "transaction_purpose_name"])
                ->hidden(["nextPaymentRequestReview", "creator", "country"])
                ->hidden($extraColumns);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function reviewsList($payoutRequestId)
    {
        try {
            $extraColumns = [];
            return PayoutRequestReviews::with(["reviewedBy:id,name"])
                ->orderBy('id', 'desc')
                ->whereRequestId($payoutRequestId)
                ->select(["id", "request_id", "required_role", "reviewed_by", "updated_at", "notes", "status"])
                ->addSelect($extraColumns)
                ->PaginateWithAppends(["is_approvable", "reviewed_by_name"])
                ->hidden($extraColumns)
                ->hidden(["reviewed_by"]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function payoutRequestSummary($payoutRequestId)
    {
        try {
            return PayoutRequest::with(["creator:id,name,email"])
                ->whereId($payoutRequestId)
                ->select(["amount", "currency", "created_at", "purpose_type", "created_by"])
                ->first()
                ->makeHidden(["creator"])
                ->append(["created_by_name", "transaction_purpose_name"]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function reviewRequest(CreatePayoutRequestReview $request)
    {
        try {
            $this->payoutService->addReview(["id" => $request->id, "status" => $request->status, "notes" => $request->notes]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
