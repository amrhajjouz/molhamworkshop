<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeductionRatio\CreateDeductionRatioRequest;
use App\Http\Requests\DeductionRatio\UpdateDeductionRatioRequest;
use App\Models\Account;
use App\Models\DeductionRatios;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DeductionRatiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function create(CreateDeductionRatioRequest $request)
    {
        try {
            $deductionRatio = $request->validated();
            $targets = $deductionRatio['targets'];
            unset($deductionRatio['targets']);

            DB::beginTransaction();
            $deductionRatio = DeductionRatios::create($deductionRatio);

            foreach ($targets as $target) {
                $deductionRatio->DeductionRatiosAccount()->create($target);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($accountId)
    {
        try {
            $accounts = DeductionRatios::whereId($accountId)
                ->select("id", "name", "description")
                ->firstOrFail();

            return response()->json($accounts);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @throws Exception
     */
    public function Update(UpdateDeductionRatioRequest $request)
    {
        try {
            $input = $request->validated();
            DeductionRatios::whereId($request->id)->update($input);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $deductionRatio = DeductionRatios::findOrFail($id);
            $deductionRatio->delete($id);
            Account::where("deduction_ratio_id", $id)->update(["deduction_ratio_id" => null]);
            DB::commit();
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        try {
            return DeductionRatios::select("id", "name", "ratio")
                ->with(["deductionRatiosAccount:id,account_id,deduction_ratio_id", "deductionRatiosAccount.account:id,name"])
                ->get()
                ->map(function ($deductionRatio) {
                    return [
                        "id" => $deductionRatio->id,
                        "name" => $deductionRatio->name[app()->getlocale()],
                        "ratio" => $deductionRatio->ratio,
                        "targets" => implode(",", $deductionRatio->deductionRatiosAccount->map(function ($deductionRatiosAccount) {
                            return $deductionRatiosAccount->account->name[app()->getlocale()];
                        })->toArray())
                    ];
                });
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function search(Request $request)
    {
        try {
            return DeductionRatios::searchByName($request->q)->select("id", "name", "ratio")
                ->get()
                ->map(function ($account) {
                    return [
                        "id" => $account->id,
                        "text" => $account->name[app()->getlocale()],
                        "ratio" => $account->ratio,
                    ];
                });
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
