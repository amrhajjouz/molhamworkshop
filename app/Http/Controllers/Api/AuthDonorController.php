<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Donor\{UpdateDonorRequest, ChangeDonorEmailRequest, ChangeDonorPasswordRequest, UpdateDonorNotificationPreferences, ChangeDonorAvatarRequest};
use App\Http\Requests\Api\SavedItem\CreateSavedItemRequest;
use App\Models\{Image, Token, NotificationPreference};
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
            if (empty($request->validated())) return handleResponse(null);
            $request->user()->update($request->validated());
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->user()->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
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
                'avatar' => $donor->avatar->url ?? null
            ]);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
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
            throw new ApiErrorException($e->getMessage());
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
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            Token::where('access_token', $request->bearerToken())->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function listNotificationPreferences(Request $request)
    {
        try {
            return handleResponse($request->user()->notificationPreferences()->pluck('name'));
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function updateNotificationPreferences(UpdateDonorNotificationPreferences $request)
    {
        try {
            $notificationPreferencesIds = NotificationPreference::whereIn('name', $request->validated()['preferences'])->get()->pluck('id');
            $request->user()->notificationPreferences()->sync($notificationPreferencesIds);
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function listPaymentMethods(Request $request)
    {
        try {
            return handleResponse($request->user()->paymentMethods->transform(function ($obj) {
                return $obj->apiTransform();
            }));
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function changeAvatar(ChangeDonorAvatarRequest $request)
    {
        try {
            $request->user()->avatar()->delete();
            $image = $request->user()->avatar()->create(["image" => $request->validated()["avatar"], "type" => "avatar"]);
            return handleResponse($image->url);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function removeAvatar(Request $request)
    {
        try {
            $request->user()->avatar()->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function listSavedItems(Request $request)
    {
        try {
            
            $dummyTitle = (app()->getLocale() == 'ar') ? 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،' : 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
            
            return handleResponse(
                $request->user()->savedItems()->get()->map(function ($item) {
                    return ['title' => $dummyTitle, $item->saveable_id, 'saveable_type' => $item->saveable_type, 'saveable_id' => $item->saveable_id];
                })
            );
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function createSavedItem(CreateSavedItemRequest $request)
    {
        try {
            $request->user()->saved_items()->firstOrCreate($request->validated());
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }


}
