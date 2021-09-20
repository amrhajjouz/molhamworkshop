<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Exception;
use Illuminate\Support\Facades\DB;

class DeductionRatiosAccountController extends Controller
{
    public function list($deductionRatio)
    {
        try {
            return Account::where("default_deduction_ratio_id", $deductionRatio)
                ->select("id", "name", "currency", "code")
                ->get();
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($deductionRatio, $accountId)
    {
        try {
            DB::beginTransaction();

            $account = Account::whereId($accountId)->where("deduction_ratio_id", $deductionRatio);

            if (!$account->exists()) {
                throw new Exception("the selected account id is not associated with the current deduction ratio");
            }

            $account->update(["deduction_ratio_id" => null]);
            DB::commit();
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function create($deductionRatio, $accountId)
    {
        try {
            DB::beginTransaction();

            $account = Account::whereId($accountId)->where("type", "sub")->where("deduction_ratio_id", null);

            if (!$account->exists()) {
                throw new Exception("the selected account does not exist or already associated with deduction ratio");
            }

            $account->update(["deduction_ratio_id" => $deductionRatio]);
            DB::commit();
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
