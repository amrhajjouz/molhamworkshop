<?php

namespace App\Http\Services\Transactions;

use App\Models\BalanceTransaction;
use App\Models\Donation;
use App\Models\Payment;
use Exception;

class  PartialItemRefundTransactionService extends PartialRefundTransactionService
{
    private $donationsToRefund = [];

    /**
     * @throws Exception
     */
    public function processPartialRefundTransaction(Payment $payment, $note, array $donationsToRefund, $withLose)
    {
        $this->withLose = $withLose;
        $this->donationsIdsToRefund = $this->donationsIdsToRefund->pluck("id")->toArray();

        $this->donationsToRefund = Donation::whereIn("id", $this->donationsIdsToRefund)->get();

        $this->processTransaction($payment, $note);
    }

    public function afterJournalsHandler(balanceTransaction $balanceTransaction)
    {
        parent::afterJournalsHandler($balanceTransaction); // I might override this again in case of issue

        $this->reInsertPaymentTransactions($balanceTransaction);
    }

    protected function updatedPaymentAfterTransaction(Payment $payment)
    {
        $totalRefundedAmount = $this->donationsIdsToRefund->sum("refund");

        $reversedFee = 0; //todo : this is wrong for now, we can to partially calculate the refunded partial fee there;

        $payment->update([
            "reversed_amount" => $payment->reversed_amount + $totalRefundedAmount,
            "reversed_fee" => $payment->reversed_fee + $reversedFee
        ]);
    }

    protected function deleteSelectedDonations($donations): void
    {
        $ids = $this->donationsIdsToRefund->pluck("id")->toArray();

        foreach ($this->donationsToRefund as $donation) {
            if (in_array($donation->id, $ids)) {
                $donation->delete();
            }
        }

        $this->reInsertTheNewPartialRefund();
    }

    private function reInsertTheNewPartialRefund()
    {
        $ids = $this->donationsIdsToRefund->pluck("id")->toArray();

        foreach ($this->donationsToRefund as $donation) {
            $refundedAmount = $this->donationsIdsToRefund->where("id", $donation->id)->first()["refund"];
            $newDonationCost = $donation->amount - $refundedAmount;
            if ($newDonationCost > 0) {
                $newDonation = $donation->replicate()->fill([
                    "amount" => $donation->amount,
                    "deleted_at" => null,
                    "deleted_by" => null,
                ]);
                $newDonation->save();
            }
        }
    }
}
