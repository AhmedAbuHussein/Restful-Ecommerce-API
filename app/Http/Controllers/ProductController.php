<?php

namespace App\Http\Controllers;

use App\Product\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductRsc\ProductResource;
use App\Http\Resources\ProductRsc\ProductCollection;
use App\Http\Requests\ProductRequest;
use App\Exceptions\ProductNotBelongToUser;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollection::collection(Product::paginate(20));
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
    public function store(ProductRequest $request)
    {
 
        $product = new Product();
        $product->name = $request->name;
        $product->detail= $request->description;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->stock= $request->stock;
        $product->img = $request->img ;
        $product->user_id = Auth::id();
        $product->save();

        return response([
            'data'=> new ProductResource($product)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->userCheck($product);

        $product->name = $request->name;
        $product->detail= $request->description;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->stock= $request->stock;
        $product->img = $request->image ;
        $product->user_id = Auth::id() ;
        $product->save();

        return response([
            'data'=> new ProductResource($product)
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->userCheck($product);
        $product->delete();
        return response(null,204);
    }

    public function userCheck($product){
        if(Auth::id() !== $product->user_id){
            throw new ProductNotBelongToUser;
        }
    }
}
