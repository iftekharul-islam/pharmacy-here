<?php


namespace Modules\Feedback\Repositories;


use Modules\Feedback\Entities\Models\Feedback;

class FeedbackRepository
{
    public function averageRating($pharmacy_id)
    {
        return Feedback::where('pharmacy_id', $pharmacy_id)->groupBy('pharmacy_id')->avg('rating');
    }

    public function create($request, $customer_id)
    {
        $feedBack = new Feedback();

        if ($request->has('pharmacy_id')) {
            $feedBack->pharmacy_id = $request->pharmacy_id;
        }
        if ($request->has('order_id')) {
            $feedBack->order_id = $request->order_id;
        }
        if ($request->has('rating')) {
            $feedBack->rating = $request->rating;
        }
        if ($request->has('comment')) {
            $feedBack->comment = $request->comment;
        }

        $feedBack->customer_id = $customer_id;

        return $feedBack->save();

    }
}
