<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request)
    {
        $rating = Rating::where([
            'user_id' => auth()->user()->id,
            'product_id' => $request->get('product_id')
        ])->first();
        
        if (!$rating) {
            $rating = new Rating();
            $rating->user_id = auth()->user()->id;
            $rating->product_id = $request->get('product_id');
        }
        $rating->rating = $request->get('rating');
        
        $rating->save();
        
        return emptyResponse();
    }
}
