<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Services\Transactions\ReversalTransactionService;
use App\Http\Requests\Payment\{CreatePaymentRequest,
    ListPaymentRequest,
    RetrievePaymentRequest,
    ReversePaymentRequest,
    UpdatePaymentRequest};
use App\Http\Services\Payments\PaymentService;
use App\Models\Account;
use App\Models\Payment;
use Exception;

class PaymentController extends Controller
{
    protected $paymentService;

    //todo: when we get all the service. we should have 1 service to do everything
    /**
     * @var ReversalTransactionService
     */
    private $reversalTransactionService;

    public function __construct(PaymentService $paymentService, ReversalTransactionService $reversalTransactionService)
    {
        parent::__construct();
        $this->paymentService = $paymentService;
        $this->reversalTransactionService = $reversalTransactionService;
    }

    public function create(CreatePaymentRequest $request)
    {
        try {
            $this->paymentService->CreatePayment($request->validated());
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function reverse($paymentId, ReversePaymentRequest $request)
    {
        try {
            $payment = Payment::with("journal")
                ->whereId($paymentId)
                ->where("status", "paid")
                ->paidOnly()
                ->firstOrFail();

            $this->reversalTransactionService->processTransaction($payment->journal, $request->notes);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdatePaymentRequest $request)
    {
        try {
            $payment = Payment::findOrFail($request->id);

            $payment->update($request->validated());

            return response()->json($payment);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($id, RetrievePaymentRequest $request)
    {
        try {
            return response()->json(Payment::findOrFail($id));
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }


    public function list()
    {
        try {
            return Payment::orderBy('id', 'desc')
                ->with("donor:id,name,email")
                ->select(["id", "amount", "currency", "status", "donor_id", "received_at", "created_at", "notes", "fee"])
                ->PaginateWithAppends(["donor_name"])
                ->hidden(["donor", "donor_id"]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function searchPaymentAccount(ListPaymentRequest $request)
    {
        try {
            $list = ["1-10", "1-11", "1-12", "1-13"];

            $accounts = Account::searchByPrefixCodeList($list)->searchByName($request->q)->with("accountCurrency")->get()->map(function ($account) {
                return [
                    "fx_rate" => $account->accountCurrency->rate,
                    "currency" => $account->currency,
                    "id" => $account->id,
                    "text" => $account->name[app()->getlocale()],
                ];
            });

            return response()->json($accounts);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
