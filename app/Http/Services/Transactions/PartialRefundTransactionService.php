<?php

namespace App\Http\Services\Transactions;

use App\Enums\BalanceTransactionEnums;
use App\Enums\PaymentStatusEnums;
use App\Models\Donation;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;

class PartialRefundTransactionService extends RefundTransactionService
{
    protected $newBalanceTransactionStatus = BalanceTransactionEnums::E_PAYMENT_PARTIAL_REFUND;
    protected $donationsToRefund = [];

    /**
     * @throws Exception
     */
    public function processPartialRefundTransaction(Payment $payment, $note, array $donationsIdsToRefund)
    {
        try {
            DB::beginTransaction();

            $allowedStatus = [PaymentStatusEnums::PAID, PaymentStatusEnums::PARTIALLY_REFUNDED];

            if (in_array($payment->type, $allowedStatus)) {
                throw new Exception("Partial refund for payment id {$payment->id} is not allowed, the type of the required payment is {$payment->type}");
            }

            $donationsToRefund = Donation::whereIn("id", $donationsIdsToRefund)->get();
            $this->donationsToRefund = $donationsToRefund;

            /**
             * Start reversing all journals and [fees ( if required )]
             */
            $newBalanceTransaction = $this->processTransaction($payment, $note); // until this point we did reverse all original payment (only )

            $reversedFee = 0;
            $reversed_amount = $donationsToRefund->sum("amount");
            if ($payment->isFeeRefundable()) { //todo: check this with amr
                $this->processFeeLoseTransactions($newBalanceTransaction);
                $reversedFee = $donationsToRefund->sum("fee");
            }
            /**
             * End processing all transactions and fees
             * At this point we did reversed everything, and we are still missing re-inserting the new journals  again
             */

            //Update the payment with the refunded fees and amount
            $payment->update([
                "reversed_amount" => $payment->reversed_amount + $reversed_amount,
                "reversed_fee" => $payment->reversed_fee + $reversedFee,
                "status" => PaymentStatusEnums::PARTIALLY_REFUNDED
            ]);

            /**
             * We have to re-process the balance transaction with the new journals and values again now
             */
            $TransactionService = new TransactionService();
            $TransactionService->processPayment($newBalanceTransaction);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    protected function deleteSelectedDonations($donations): void
    {
        $ids = $this->donationsToRefund->pluck('id')->toArray();
        foreach ($donations as $donation) {
            if (in_array($donation->id, $ids)) {
                $donation->delete();
            }
        }
    }
}
