<?php

namespace App\Http\Controllers;

use App\Product\Review\Review;
use Illuminate\Http\Request;
use App\Product\Product;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\ReviewRequest;
use App\Exceptions\ProductNotBelongToUser;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request,Product $product)
    {
        
        $review = new Review($request->all());
        $product->reviews()->save($review);

        return response()->json([
            'data'=> new ReviewResource($review)
        ],201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product\Review\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product\Review\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product\Review\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request,Product $product, Review $review)
    {
        if(Auth::id() !== $product->user_id){
            throw new ProductNotBelongToUser;
        }
        $review->update($request->all());
        return response()->json([
            'data'=> new ReviewResource($review)
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product\Review\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Review $review)
    {
        if(Auth::id() !== $product->user_id){
            throw new ProductNotBelongToUser;
        }
        $review->delete();
        return response()->json(null,204);
    }
}
