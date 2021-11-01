<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\{CreateAccountRequest, UpdateAccountRequest};
use App\Models\{Account, AccountBranch};
use Exception;

class AccountController extends Controller
{
    /**
     * @throws Exception
     */
    public function create(CreateAccountRequest $request)
    {
        try {
            $account = $request->validated();
            $accountBranch = AccountBranch::whereId($request->account_branch_id)
                ->where("type", "main")
                ->with(["parentAccountBranch:id,code", "childAccounts:id,branch_id"])
                ->firstOrFail();

            if ($accountBranch->IsChildOfMainTitle == false) {
                $account["currency"] = Account::$currencyDefault;
                $account["country_code"] = Account::$countryCodeDefault;
            }

            if (empty($account["currency"])) {
                throw new Exception("currency is required");
            }

            if (empty($account["country_code"])) {
                throw new Exception("currency is required");
            }

            $accountBranchNextChildCount = count($accountBranch->childAccounts) + 1;
            $account["code"] = "{$accountBranch->code}-{$accountBranchNextChildCount}";

            $accountBranch->childAccounts()->create($account);
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
            Account::whereId($request->id)->update($input);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($accountId)
    {
        try {
            $accounts = Account::whereId($accountId)
                ->select("id", "name", "description")
                ->firstOrFail();

            return response()->json($accounts);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list()
    {
        try {
            return Account::get(
                ["id", "name", "currency", "country_code", "code", "balance", "description", "branch_id", "default_deduction_ratio_id"])
                ->makeHidden("parentAccountBranch")
                ->append("main_name_account_branch");
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function search()
    {
        try {
            $accounts = Account::searchByName(request()->q)
                ->get(["name", "id"])
                ->map(function ($account) {
                    return [
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
