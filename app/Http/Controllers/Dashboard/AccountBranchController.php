<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Http\Requests\AccountBranch\CreateAccountBranchRequest;
use App\Models\AccountBranch;
use Exception;

class AccountBranchController extends Controller
{
    /**
     * @throws Exception
     */
    public function create(CreateAccountBranchRequest $request)
    {
        try {
            $account = $request->validated();

            $titleAccount = AccountBranch::whereId($account["parent_id"])
                ->where("type", "title")
                ->with(["parentAccountBranch:id,code", "childAccounts:id,branch_id"])
                ->firstOrFail();

            $account["type"] = "main";
            $account["code"] = $titleAccount->nextExpectedCode;
            AccountBranch::create($account);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @throws Exception
     */
    public function Update(UpdateAccountRequest $request)
    {
        try {
            $input = $request->validated();
            AccountBranch::whereId($request->id)->update($input);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function search()
    {
        try {
            $accounts = AccountBranch::searchByName(request()->q)
                ->searchByType(request("type"))
                ->select("name", "id", "code", "parent_id")
                ->with(["childBranchAccounts:id,parent_id"])
                ->take(10)
                ->get()
                ->map(function ($account) {
                    return [
                        "id" => $account->id,
                        "text" => $account->name[app()->getlocale()],
                        "isMainTitle" => $account->isMainTitle,
                        "nextExpectedCode" => $account->nextExpectedCode,
                    ];
                });
            return response()->json($accounts);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function listMain()
    {
        try {
            return AccountBranch::whereType("main")
                ->with(["parentAccountBranch:id,name,parent_id,code"])
                ->select("id", "name", "type", "code", "balance", "parent_id")
                ->get()
                ->map(function ($account) {
                    $parentDetails = $account->parent_details;
                    return [
                        "id" => $account->id,
                        "name" => $account->name,
                        "currency" => $account->currency,
                        "code" => $account->code,
                        "balance" => $account->balance,
                        "is_child_of_main_title" => $account->isChildOfMainTitle,
                        "title_name" => $parentDetails["title"]["name"][app()->getlocale()],
                    ];
                });
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
