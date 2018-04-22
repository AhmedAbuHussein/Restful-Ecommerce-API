<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('display');
    }
    public function item($id){
        return view('item',['id'=>$id]);
    }
    public function profile($id){
        
        $user = \App\User::find($id);
        $arr = array(
            'user'=>$user
        );
        return view('profile',$arr);
    }

    public function additem(){
        return view('additem');

    }
    public function saveImage(Request $req){

        if($req->hasFile('img')){
            $imagename = time() . "." . $req->img->getClientOriginalExtension();
            $req->img->move(public_path('images'),$imagename);
        }
        $product = new Product();
        $product->name =$req->name;
        $product->detail =$req->description;
        $product->price =$req->price;
        $product->discount =$req->discount;
        $product->stock =$req->stock;
        $product->user_id = \Illuminate\Support\Facades\Auth::id();
        $product->img =$imagename;
        $product->save();
        return response($product,202);

    }
}
