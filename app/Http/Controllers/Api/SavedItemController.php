<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use Illuminate\Http\Request;
use App\Http\Requests\Api\SavedItem\{CreateSavedItemRequest , DeleteSavedItemRequest};

class SavedItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor');
    }

 
    public function create(CreateSavedItemRequest $request)
    {
        try {
            authDonor()->savedItems()->firstOrCreate($request->validated());
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function delete(DeleteSavedItemRequest $request , $id)
    {
        try {
            authDonor()->savedItems()->where('id' , $id)->delete();

            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }

    }


}
