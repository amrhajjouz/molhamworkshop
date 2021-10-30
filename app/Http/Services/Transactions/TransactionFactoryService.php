<?php

namespace App\Http\Services\Transactions;

use App\Enums\BalanceTransactionEnums;
use App\Enums\PaymentStatusEnums;
use App\Models\BalanceTransaction;
use App\Models\Journals;
use Exception;

class TransactionFactoryService
{
    /**
     * @var TransactionService
     */
    private $manualTransactionService;

    public function __construct(TransactionService $manualTransactionService)
    {
        $this->manualTransactionService = $manualTransactionService;
    }

    /**
     * @throws Exception
     */
    public function Process($balanceTransactionId)
    {
        $balanceTransaction = BalanceTransaction::find($balanceTransactionId);
        switch ($balanceTransaction->type) {
            case BalanceTransactionEnums::MANUAL_PAYMENT:
                $this->manualTransactionService->processPayment($balanceTransaction);
        }
    }
}
