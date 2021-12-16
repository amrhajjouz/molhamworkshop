<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Feedback\{CreateFeedbackRequest , UpdateFeedbackRequest};
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function create(CreateFeedbackRequest $request)
    {
        try {
            $data = array_merge($request->validated() , ['donor_id' => authDonor()->id]);
            return response()->json(Feedback::create($data));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateFeedbackRequest $request, $id)
    {
        try {
            $data = array_merge($request->validated() , ['donor_id' => authDonor()->id]);
            $feedback = Feedback::findOrFail($id);
            $feedback->update($data);
            return response()->json($feedback);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            Feedback::findOrFail($id)->delete();
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
