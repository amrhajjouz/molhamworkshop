<?php

namespace App\Http\Services\Payments;

use App\Http\Services\Transactions\TransactionFactoryService;
use App\Http\Services\Transactions\TransactionService;
use App\Models\Account;
use App\Models\DeductionRatios;
use App\Models\Payment;
use App\Models\Purpose;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * @var TransactionService
     */
    private $transactionService;

    public function __construct(TransactionFactoryService $transactionService)
    {

        $this->transactionService = $transactionService;
    }

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
            $payment["method"] = "cash"; //todo later with the correct one
            $payment["status"] = "paid";
            $payment["amount"] = collect($purposes)->sum("amount");

            DB::beginTransaction();

            $paymentResult = Payment::create($payment);

            foreach ($purposes as $item) {
                $purpose = Purpose::whereId($item["purpose_id"])->firstOrFail();
                $deductionRatio = DeductionRatios::whereId($item["deduction_ratio_id"])->firstOrFail(["id","account_id"]);

                $paymentResult->donations()->create(array(
                    "usd_amount" => $item["amount"] / $paymentResult->fx_rate,
                    "deduction_ratio_id" => $deductionRatio->id,
                    "deduction_account_id" => $deductionRatio->account_id,
                    "country_code" => $payment["country_code"],
                    "amount" => $item["amount"],
                    "received_at" => $paymentResult->received_at,
                    "targetable_id" => $purpose->targetable_id,
                    "targetable_type" => null, //todo
                    "donor_id" => $paymentResult->donor_id,
                    "currency" => $paymentResult->currency,
                    "section_id" => $purpose->section_id,
                    "program_id" => $purpose->program_id,
                    "purpose_id" => $purpose->id,
                    "reference" => Str::uuid(),
                    "method" => $paymentResult->method,
                    "fee" => 0,
                ));
            }

            $journal = $paymentResult->journal()->create([
                "type" => "payment", //todo later with the correct one
                "notes" => $paymentResult->notes,
            ]);

            DB::commit();

            $this->transactionService->Process($journal->id);

        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
