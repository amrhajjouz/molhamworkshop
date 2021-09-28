<?php

namespace App\Http\Services\Payments;

use App\Models\Account;
use App\Models\Payment;
use App\Models\Purpose;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * @throws Exception
     */
    public function CreatePayment($payment)
    {
        try {
            $purposes = $payment["purposes"];

            unset($payment["purposes"]);

            if (!isset($payment["notes"])) {
                $payment["notes"] = null;
            }

            $account = Account::Where("id", $payment["account_id"])->first();

            if ($account == null) { //in case the account is not active ( when we add that flag later)
                throw new Exception("the requested account is not active");
            }

            $payment["received_at"] = date("Y-m-d", strtotime($payment["received_at"]));
            $payment["currency"] = $account->currency;
            $payment["method"] = "cash";
            $payment["status"] = "paid";
            $payment["amount"] = collect($purposes)->sum("amount");

            DB::beginTransaction();

           $paymentResult = Payment::create($payment);

            foreach ($purposes as $item) {
                $purpose = Purpose::whereId($item["purpose_id"])->firstOrFail();

                $paymentResult->donations()->create(array(
                    "usd_amount" => $item["amount"] / $paymentResult->fx_rate,
                    "deduction_ratio_id" => $item["deduction_ratio_id"],
                    "country_code" => $payment["country_code"],
                    "amount" => $item["amount"],
                    "received_at" => $paymentResult->received_at,
                    "targetable_id" => $purpose->targetable_id,
                    "donor_id" => $paymentResult->donor_id,
                    "currency" => $paymentResult->currency,
                    "section_id" => $purpose->section_id,
                    "program_id" => $purpose->program_id,
                    "purpose_id" => $purpose->id,
                    "reference" => Str::uuid(),
                    "method" => "cash",
                    "fee" => 0,
                ));
            }

            DB::commit();
        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
