<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\Donor\{UpdateDonorRequest, ChangeDonorEmailRequest, ChangeDonorPasswordRequest, UpdateDonorPrefrencesRequest, UpdateDonorNotificationPreferences};
use App\Models\{Token, NotificationPreference, PaymentMethod};
use Illuminate\Support\Facades\Hash;

class AuthDonorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor');
    }

    public function update(UpdateDonorRequest $request)
    {
        try {
            $request->user()->update($request->validated());
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->user()->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function retrieve(Request $request)
    {
        try {
            $donor = $request->user();
            return handleResponse([
                'id' => $donor->id,
                'name' => $donor->name,
                'email' => $donor->email,
                'phone' => $donor->phone,
                'country_code' => $donor->country_code,
                'currency' => $donor->currency,
                'locale' => $donor->locale,
                'theme_mode' => $donor->theme_mode,
                'theme_color' => $donor->theme_color,
            ]);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function changePassword(ChangeDonorPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $donor = $request->user();
            $donor->password = Hash::make($data['new_password']);
            $donor->save();
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function changeEmail(ChangeDonorEmailRequest $request)
    {
        try {
            $data = $request->validated();
            $donor = $request->user();
            $donor->email = $data['new_email'];
            $donor->save();
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function updatePreferences(UpdateDonorPrefrencesRequest $request)
    {
        try {
            $donor = $request->user();
            $donor->update($request->validated());
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        try {
            Token::where('access_token', $request->bearerToken())->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function listNotificationPreferences(Request $request)
    {
        try {
            return handleResponse($request->user()->notification_preferences()->pluck('name'));
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function updateNotificationPreferences(UpdateDonorNotificationPreferences $request)
    {
        try {
            $notificationPreferencesIds = NotificationPreference::whereIn('name', $request->validated()['preferences'])->get()->pluck('id');
            $request->user()->notification_preferences()->sync($notificationPreferencesIds);
            return handleResponse(null);
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }

    public function listPaymentMethods(Request $request)
    {
        try {
            return handleResponse($request->user()->payment_methods->transform(function ($obj) {
                return $obj->apiTransform();
            }));
        } catch (\Exception $e) {
            return handleResponse(['error' => $e->getMessage()]);
        }
    }
}
