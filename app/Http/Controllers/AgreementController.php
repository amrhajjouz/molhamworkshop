<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agreement\CreateAgreementRequest;
use App\Http\Requests\Agreement\UpdateAgreementRequest;
use App\Models\agreement;
use App\Models\Voucher;
use Exception;
use Illuminate\Support\Facades\DB;

class AgreementController extends Controller
{
    public function list()
    {
        try {
            return Agreement::orderBy('id', 'desc')
                ->with("vouchers:id,amount,agreement_id")
                ->select(["id", "currency", "amount", "title", "admin_costs_percentage", "details", "status", "canceled_by", "starting_date", "ending_date"])
                ->PaginateWithAppends(["vouchers_total_amount", "vouchers_number"])
                ->hidden(["vouchers"]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function create(CreateAgreementRequest $request)
    {
        try {
            $agreement = Agreement::create($request->validated());
            return response()->json($agreement);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieveAgreement($id)
    {
        try {
            return response()->json(Agreement::findOrFail($id));
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateAgreementRequest $request)
    {
        try {
            $agreement = Agreement::findOrFail($request->id);

            $input = $request->validated();

            if ($agreement->status != 'pending') {
                throw new Exception("You can't update none pending status");
            }

            $agreement->update($input);
            
            return response()->json($agreement);
        } catch (Exception     $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function updateState($agreementId)
    {
        try {
            $agreement = Agreement::findOrFail($agreementId);

            DB::beginTransaction();

            if ($agreement->status != 'pending') {
                throw new Exception("You can't update none pending status");
            }

            $vouchers = Voucher::where("agreement_id", $agreement->id)->get();

            if (request()->status == 'cancel') {
                $vouchers->each->update(['agreement_id' => null]); // re-invoke the agreement_id from the old agreement
            } elseif (request()->status == 'completed') {
                $amount = $vouchers->sum("amount");
                $amount = $amount + ( $amount * $agreement->admin_costs_percentage / 100);
                if ($amount != $agreement->amount) {
                    throw new Exception("The agreement is not ready yet, expected $agreement->amount but it was $amount");
                }
            }

            $agreement->update(["status" => request()->status]);
            DB::commit();

        } catch (Exception     $e) {
            DB::rollBack();
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function assignedVouchersList($agreementId)
    {
        try {
            $vouchers = Voucher::where("agreement_id", $agreementId)
                ->select(["id", "amount", "currency", "agreement_id"])->paginate(10);

            return response()->json($vouchers);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function invokeVoucherFromAgreement($agreementId, $voucherId)
    {
        try {
            $voucher = Voucher::whereId($voucherId)->where("agreement_id", $agreementId)->with("agreement:id,status")->firstOrFail();

            if ($voucher->agreement->status != "pending") {
                throw new Exception("You can't invoke none pending agreement.");
            }

            $voucher->update(["agreement_id" => null]);

            return response()->json();
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function assignVoucherToAgreement($agreementId, $voucherId)
    {
        try {
            $voucher = Voucher::whereId($voucherId)->firstOrFail();

            if ($voucher->agreement_id != null) {
                throw new Exception("This voucher already assigned to agreement {$voucher->agrement->id}, invoke it first and try again.");
            }

            if ($voucher->delivered_at == null) {
                throw new Exception("This voucher is not delivered yet. make sure to assign only completed voucher");
            }

            $agreement = Agreement::whereId($agreementId)->firstOrFail();

            if ($agreement->status != "pending") {
                throw new Exception("You can't invoke none pending agreement.");
            }

            if ($voucher->currency != $agreement->currency) {
                throw new Exception("You can't assign {$voucher->currency} voucher to {$voucher->agreement->currency} agreement");
            }

            $voucher->update(["agreement_id" => $agreementId]);

            return response()->json("success");
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function summary($agreementId)
    {
        try {
            $agreement = Agreement::whereId($agreementId)
                ->select(["id", "currency", "amount", "title", "admin_costs_percentage"])
                ->firstOrFail();
            return response()->json($agreement);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
