<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\CreateReviewRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{

    public function create(CreateReviewRequest $request)
    {
        try {
            return response()->json(Review::create($request->validated()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateReviewRequest $request, $id)
    {
        try {
            $review = Review::findOrFail($id);
            $review->update($request->validated());
            return response()->json($review);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function list(Request $request)
    {
        try {
            $reviews = Review::orderBy('id', 'desc')->paginate(20)->withQueryString();
            $reviews->getCollection()->transform(function ($review, $key) {
                $donor = $review->donor;
                return [
                    'id' => $review->id,
                    'donor' => [
                        'name' => $donor->name, 'avatar_url' => $donor->avatar ? $donor->avatar->url : null
                    ],
                    'content' => $review->content,
                    'created_at' => $review->created_at,
                ];
            });
            return response()->json($reviews);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            Review::destroy($id);
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
