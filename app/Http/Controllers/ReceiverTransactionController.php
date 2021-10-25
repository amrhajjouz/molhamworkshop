<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\ReceivedTransactionService;
use App\Http\Requests\Receiver\Transaction\CreateTransactionRequest;
use App\Models\Receiver;
use App\Models\ReceiverTransaction;
use App\Shared\TransactionHelper;
use Exception;
use Illuminate\Support\Facades\DB;

class ReceiverTransactionController extends Controller
{
    protected $transactionService;

    public function __construct(ReceivedTransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public static function TypeList(): array
    {
        return TransactionHelper::TypeList();
    }

    public function create(CreateTransactionRequest $request)
    {
        try {
            $data = $request->validated();
            $this->transactionService->handleTransaction($data);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete()
    {
        try {
            DB::beginTransaction();
            $transaction = ReceiverTransaction::find(request()->transaction);
            if ($transaction->related_to != null) {
                $transactionRelated = ReceiverTransaction::find($transaction->related_to);
            } else {
                $transactionRelated = $transaction->baseTransaction;
            }
            $account = $transaction->account;
            $relatedAccount = $transactionRelated->account;
            $transaction->delete();
            $transactionRelated->delete();
            $account->fixIncomeOutcome();
            $relatedAccount->fixIncomeOutcome();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list(Receiver $receiver)
    {
        try {
            return ReceiverTransaction::with(["transactionRelated.account.receiver"])
                ->orderBy('id', 'desc')
                ->getByReceiverId($receiver->id)
                ->PaginateWithAppend("extra_description");
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
