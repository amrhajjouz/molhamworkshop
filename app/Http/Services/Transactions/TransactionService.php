<?php

namespace App\Http\Services\Transactions;

use App\Models\Journals;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function Process($journalId)
    {
        $journal = Journals::find($journalId);
        switch ($journal->type) {
            case "manual_payment":
                $this->processManualPayment($journal);
        }
    }

    /**
     * @throws Exception
     */
    private function processManualPayment($journal)
    {
        try {
            DB::beginTransaction();

            DB::commit();
        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
