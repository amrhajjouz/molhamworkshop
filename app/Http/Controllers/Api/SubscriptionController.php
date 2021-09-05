<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use App\Http\Requests\Api\Subscription\{CreateSubscriptionRequest,};
use App\Models\DonationItem;

class SubscriptionController extends Controller
{
    public function create(CreateSubscriptionRequest $request)
    {
        try {
            $data = $request->validated();
            $items = $data['items'];
            foreach ($items as $item) {DonationItem::create($item);}
            unset($data['items']);
            $donor = $request->user();
            $subscription = $donor->subscriptions()->create($data);
            return handleResponse(['id'=>$subscription->id , 'reference' => $subscription->reference , 'total_amount'=>$subscription->total_amount , 'status'=>$subscription->status]);
        } catch (\Exception $e) {
            throw new ApiErrorException($e->getMessage());
        }
    }

    
}
