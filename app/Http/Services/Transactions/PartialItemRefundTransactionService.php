<?php

namespace App\Http\Services\Transactions;

use App\Enums\PaymentStatusEnums;
use App\Models\Donation;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class  PartialItemRefundTransactionService extends PartialRefundTransactionService
{
    /**
     * @throws Exception
     */
    public function processPartialItemRefundTransaction(Payment $payment, $note, Collection $itemsDetailsToRefunds)
    {
        try {
            DB::beginTransaction();

            $donationsIdsToRefund = $itemsDetailsToRefunds->pluck("id")->toArray();
            $donationsToRefund = Donation::whereIn("id", $donationsIdsToRefund)->get();
            $this->verifyIfRefundable($payment, $donationsToRefund, $itemsDetailsToRefunds);

            $this->donationsToRefund = $donationsToRefund;

            /**
             * reversing all existing journals ( without lose )
             */
            $newBalanceTransaction = $this->processTransaction($payment, $note); // until this point we did reverse all original payment (only )

            //because this is partial item refund, we have to re-insert the partially refunded item with the new values
            $newInsertedDonations = $this->reInsertTheNewPartialRefund($donationsToRefund, $itemsDetailsToRefunds, $payment->isFeeRefundable());

            $this->updatePaymentAfterProcessingTransaction($payment, $itemsDetailsToRefunds->sum("refund"), $donationsToRefund->sum("fee"), $newInsertedDonations->sum("fee"));
            $payment->fresh();

            if ($this->isPaymentRequiredLoseFeeTransaction($payment)) {
                $this->processFeeLoseTransactions($newBalanceTransaction);
            }

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

    /**
     * @throws Exception
     */
    private function verifyIfRefundable(Payment $payment, Collection $donationsToRefund, Collection $itemsToRefunds)
    {
        $allowedStatus = [PaymentStatusEnums::PAID, PaymentStatusEnums::PARTIALLY_REFUNDED];

        if (in_array($payment->type, $allowedStatus)) {
            throw new Exception("Partial refund for payment id {$payment->id} is not allowed, the type of the required payment is {$payment->type}");
        }

        if (count($donationsToRefund) == 0) {
            throw new Exception("No items to refund passed.");
        }

        foreach ($donationsToRefund as $donation) {
            $refundAmount = $itemsToRefunds->where("id", $donation->id)->first()['refund'];
            if ($refundAmount > $donation->amount) {
                throw new Exception("Partial item refund for donation {$donation->id} is not possible. The current donation amount {$donation->amount} but you are refunding {$refundAmount} ");
            }

            if ($refundAmount <= 0) {
                throw new Exception("Amount partial refund {$refundAmount} for donation {$donation->id} is not allowed");
            }
        }
    }

    private static function reInsertTheNewPartialRefund(Collection $refundedDonations, Collection $itemsDetailsToRefunds, bool $isFeeRefundable): Collection
    {
        $newDonations = array();
        foreach ($refundedDonations as $donation) {
            $fee = $donation->fee;
            $refundedAmount = $itemsDetailsToRefunds->where("id", $donation->id)->first()["refund"];
            $newDonationCost = $donation->amount - $refundedAmount;

            if ($isFeeRefundable) {
                $fee = ($newDonationCost * $donation->fee) / $donation->amount;
            }

            if ($newDonationCost > 0) {
                $newDonation = $donation->replicate()->fill([
                    "amount" => $newDonationCost,
                    "fee" => $fee,
                    "deleted_at" => null,
                    "deleted_by" => null,
                ]);
                $newDonation->save();
                $newDonations[] = $newDonation;
            }
        }
        return collect($newDonations);
    }

    private function updatePaymentAfterProcessingTransaction(Payment $payment, float $reversedAmount, float $oldTotalFee, float $newTotalFee): void
    {
        $reversedFee = $oldTotalFee - $newTotalFee;
        $payment->update([
            "reversed_amount" => $payment->reversed_amount + $reversedAmount,
            "reversed_fee" => $reversedFee - $payment->reversed_fee, // subtract with the old fee
            "status" => PaymentStatusEnums::PARTIALLY_REFUNDED
        ]);
    }
}
