<?php

namespace App\Http\Controllers\Services;

use App\Models\Account;
use App\Models\PaymentTransaction;
use App\Models\PayoutRequest;
use App\Models\PayoutRequestReviews;
use App\Models\ReceiverTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery\Exception;

class PayoutService
{
    public function CreatePayoutRequest($data)
    {
        try {
            DB::beginTransaction();

            if(!isset($data["details"])){
                $data["details"] = null;
            }

            $payoutRequest = PayoutRequest::create([
                "amount" => $data["amount"],
                "currency" => $data["currency"],
                "purpose_type" => $data["purpose_type"], // todo: for later work => make sure this is verified from the validator when we complete the missing parts
                "purpose_id" => null,
                "assignee_id" => $data["assignee_id"],
                "details" => $data["details"],
                "country_id" => $data["country_id"],
                "status" => "pending",
            ]);

            $this->createPayoutRequestReviewers($payoutRequest);

            DB::commit();

            return $payoutRequest;

        } catch (\Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    private function createPayoutRequestReviewers($payoutRequest) //todo later. I just created 2 now for testing purppse
    {

        $requiredRoles = $this->GetRequiredRoles($payoutRequest->purpose_type, $payoutRequest->amount);

        $reviews = array();
        foreach ($requiredRoles as $role) {
            $reviews[] = $payoutRequest->payoutRequestReviews()->create([
                "required_role" => $role["role"],
                "priority" => $role["priority"],
                "status" => "pending"
            ]);
        }

        $payoutRequest->update(["next_review_id" => $reviews[0]->id]);
    }

    private function GetRequiredRoles($purpose, $amount) //this method will be used only when we create the required roles
    {
        //todo $purpose will be ignored now

        $priority = 0;
        $result [] = ["role" => "role 1", "priority" => ++$priority]; //todo change later when we get the full picture
        $result [] = ["role" => "role 2", "priority" => ++$priority];

        if ($amount > 1000) {
            $result [] = ["role" => "role 3", "priority" => ++$priority];
        }

        if ($amount > 5000) {
            $result [] = ["role" => "role 4", "priority" => ++$priority]; //atef
        }

        $result [] = ["role" => "role 5", "priority" => 1]; // accounter

        return $result;
    }

    public function addReview(array $data)
    {
        try {
            DB::beginTransaction();

            $paymentRequestUnderReview = PayoutRequestReviews::with("payoutRequest")
                ->find($data["id"]);

            if ($paymentRequestUnderReview->status != "pending" || $paymentRequestUnderReview->payoutRequest->status != "pending") {
                throw new Exception("The requested state already reviewed");
            }

            if (!auth()->user()->hasRole($paymentRequestUnderReview->required_role)) {
                throw new Exception("You don't have the right to add review to the current state");
            }

            $allReviews = $paymentRequestUnderReview->payoutRequest->payoutRequestReviews;

            $previousReviews = $allReviews->where('id', '<', $data["id"]);

            $isLastReview = $allReviews->max("id") == $data["id"];

            if ($previousReviews->count() > 0 && $previousReviews->last()->status == "pending" && $previousReviews->last()->priority >= $paymentRequestUnderReview->priority) {
                throw new Exception("You are still not allowed to review this request");
            }

            $paymentRequestUnderReview->update([
                "reviewed_by" => auth()->id(),
                "status" => $data["status"],
                "notes" => $data["notes"]
            ]);

            if ($previousReviews->count() > 0 && $previousReviews->last()->priority < $paymentRequestUnderReview->priority) {
                $previousReviews = PayoutRequestReviews::where("request_id", $paymentRequestUnderReview->request_id)->where('id', '<', $data["id"])->get();
                foreach ($previousReviews as $review) {
                    $review->update([
                        "reviewed_by" => auth()->id(),
                        "status" => $data["status"],
                        "notes" => $data["notes"]
                    ]);
                }
            }

            if ($data["status"] == "rejected") {
                $updatedPaymentRequest = [
                    "rejected_by" => auth()->id(),
                    "rejected_at" => now(),
                    "status" => "rejected"
                ];
            } else if ($isLastReview) {
                $updatedPaymentRequest = [
                    "status" => "approved",
                ];
            } else {
                $updatedPaymentRequest = [
                    "next_review_id" => $paymentRequestUnderReview->id + 1,
                ];
            }

            $paymentRequestUnderReview->payoutRequest->update($updatedPaymentRequest);
            DB::commit();
        } catch (\Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function createPayoutPayment($voucher)
    {
        try {
            DB::beginTransaction();

            $account = Account::find($voucher->account_id);

            if ($account->left < $voucher->amount) {
                throw new Exception("Failed to create the payout transaction, insufficient amount of money in {$account->name} account");
            }

            if ($account->status != "active") {
                throw new Exception("Failed to create the payout transaction,The associated account is not active");
            }

            $paymentTransaction = PaymentTransaction::create([
                    "type" => "payout",
                    "purpose_type" => $voucher->purpose_type,
                    "amount" => $voucher->amount * -1,
                    "notes" => $voucher->details]
            );

            $receiverTransaction = ReceiverTransaction::create([
                "type" => "payout",
                "account_id" => $account->id,
                "currency" => $voucher->currency,
                "amount" => $voucher->amount * -1,
                "usd_rate" => 1,
                "notes" => $voucher->details
            ]);

            $payout = $voucher->payout()->create([
                "amount" => $voucher->amount,
                "currency" => $voucher->currency,
                "reference" => Str::uuid(),
                "created_at" => $voucher->getOriginal('created_at'),
                "country_id" => $voucher->country_id,
                "payment_transaction_id" => $paymentTransaction->id,
                "receiver_transaction_id" => $receiverTransaction->id,
                "payout_request_id" => $voucher->id,
            ]);

            $account->FixIncomeOutcome();

            DB::commit();
        } catch (\Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
