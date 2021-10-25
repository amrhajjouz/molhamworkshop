<?php

namespace App\Http\Controllers;

use App\Http\Requests\Receiver\Account\CreateAccountRequest;
use App\Http\Requests\Receiver\Account\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Receiver;
use Exception;

class AccountController extends Controller //todo: I would suggest another name here
{
    public function list(Receiver $receiver)
    {
        try {
            return response()->json($receiver->accounts()->get());
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function search()
    {
        try {
            $accounts = Account::searchByName(request()->q)
                ->searchByCurrency(request()->currency)
                ->exceptReceiver(request()->except_receiver)
                ->onlyActive()
                ->with("receiver:id,name")
                ->select("name", "id", "receiver_id", "currency")->get()
                ->map(function ($account) {
                    return [
                        "id" => $account->id,
                        "text" => $account->receiver->name . " - " . $account->name . " - " . $account->currency
                    ];
                });

            return response()->json($accounts);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function create(Receiver $receiver, CreateAccountRequest $request)
    {
        try {
            $data = $request->validated();
            $data["left"] = $data["initial_balance"];
            $data["income"] = 0;
            $data["outcome"] = 0;
            $receiver = $receiver->accounts()->create($data);
            return response()->json($receiver);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateAccountRequest $request)
    {
        try {
            $account = Account::findOrFail($request->id);
            $data = $request->validated();
            $data["left"] = $request->initial_balance + $account->income - $account->outcome;
            $account->update($data);
            return response()->json($account);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
