<?php

namespace App\Http\Services\Transactions;

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
    public function Process($journalId)
    {
        $journal = Journals::find($journalId);
        switch ($journal->type) {
            case "manual_payment":
                $this->manualTransactionService->processManualPayment($journal);
        }
    }
}
