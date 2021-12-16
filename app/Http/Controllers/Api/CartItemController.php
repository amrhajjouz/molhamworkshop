<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use App\Http\Requests\Api\CartItem\{CreateCartItemRequest , DeleteCartItemRequest};
use App\Models\CartItem;

class CartItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor');
    }
 
    public function create(CreateCartItemRequest $request)
    {
        try {
            $donor = authDonor();
            $data = array_merge($request->validated() , ['donor_id' => $donor->id , 'currency' => $donor->currency]);
            CartItem::firstOrCreate($data);
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function delete(DeleteCartItemRequest $request , $id)
    {
        try {
            CartItem::find($id)->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function deleteCartItems(DeleteCartItemRequest $request)
    {
        try {
            CartItem::where(['donor_id' => authDonor()->id])->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

}
