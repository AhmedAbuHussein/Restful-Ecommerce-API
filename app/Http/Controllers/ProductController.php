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

    
    public function index()
    {
        return ProductCollection::collection(Product::paginate(20));
    }

   

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

    
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

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
