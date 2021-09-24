<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Feedback\{CreateFeedbackRequest , UpdateFeedbackRequest};
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function create(CreateFeedbackRequest $request)
    {
        try {
            return response()->json(authDonor()->feedbacks()->create($request->validated()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateFeedbackRequest $request, $id)
    {
        try {
            $feedback = authDonor()->feedbacks()->where('id',$id)->firstOrFail();
            $feedback->update($request->validated());
            return response()->json($feedback);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            authDonor()->feedbacks()->where('id',$id)->delete();
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
