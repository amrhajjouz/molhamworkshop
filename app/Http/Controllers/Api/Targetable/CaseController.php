<?php

namespace App\Http\Controllers\Api\Targetable;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Donor\{UpdateDonorRequest, ChangeDonorEmailRequest, ChangeDonorPasswordRequest, UpdateDonorNotificationPreferences, ChangeDonorAvatarRequest};
use App\Models\{Token, NotificationPreference};
use Illuminate\Support\Facades\Hash;

class CaseController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth_donor');
    }

    public function list(Request $request)
    {
        try {
            return response()->json(collect(listDummyCases()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
