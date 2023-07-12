<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function addReview(Request $request) 
    {   
        if (Auth::id()) {
            $data = $request->validate([
                'rating' => 'required',
                'product_id' => 'required',
                'message' => 'required|max:250'
            ]);
     
            $data['name'] = auth()->user()->name;
            $data['user_id'] = auth()->user()->id;
    
            Review::create($data);
    
            return redirect()->back()->with('success', 'Thank you for giving a review');
        } else {
            return redirect('/login')->with('logFirst', 'You must login first');
        }
    }
    public function review() 
    {
        return view('dashboard.products.reviews.index', [
            'reviews' => Review::latest()->paginate(20)
        ]);
    }
    public function removeReview(Review $review) 
    {
        Review::destroy($review->id);
        return redirect('/dashboard/products/reviews')->with('success', 'A review has been deleted!');
    }
}