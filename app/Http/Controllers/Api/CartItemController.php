<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use App\Http\Requests\Api\CartItem\{CreateCartItemRequest , DeleteCartItemRequest};

class CartItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor');
    }
 
    public function create(CreateCartItemRequest $request)
    {
        try {
            authDonor()->cartItems()->firstOrCreate($request->validated());
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function delete(DeleteCartItemRequest $request , $id)
    {
        try {
            authDonor()->cartItems()->where('id' , $id)->delete();

            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

}
