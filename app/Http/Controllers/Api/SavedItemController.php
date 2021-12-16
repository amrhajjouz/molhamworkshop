<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use Illuminate\Http\Request;
use App\Http\Requests\Api\SavedItem\{CreateSavedItemRequest , DeleteSavedItemRequest};
use App\Models\SavedItem;

class SavedItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor');
    }

 
    public function create(CreateSavedItemRequest $request)
    {
        try {
            $data = $request->validated();
            $data['donor_id'] = authDonor()->id;
            SavedItem::firstOrCreate($data);
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function delete(DeleteSavedItemRequest $request)
    {
        try {
            $data = $request->validated();
            SavedItem::where(['saveable_type' => $data['saveable_type'] , 'saveable_id' => $data['saveable_id'] , 'donor_id' => authDonor()->id])->firstOrFail()->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }

    }


}
