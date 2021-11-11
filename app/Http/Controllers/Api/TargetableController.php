<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Donor\{UpdateDonorRequest, ChangeDonorEmailRequest, ChangeDonorPasswordRequest, UpdateDonorNotificationPreferences, ChangeDonorAvatarRequest};
use App\Http\Resources\Dashboard\Program\Medical\Cases\CasesListResource;
use App\Models\{Cases, Token, NotificationPreference};
use Illuminate\Support\Facades\Hash;

class TargetableController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth_donor');
    }

    public function list(Request $request, $type)
    {
        try {
            return response()->json(collect(listDummyTargetables($type)));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
   
    public function retrieve(Request $request , $type, $id)
    {
        try {
            return response()->json(retrieveDummySingleTargetable($type, $id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
