<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(\Auth::user()->is_permission == 0)
        {
            $cart_items = Cart::where('selected_by',Auth::id())->latest()->get();
            return view('cart.index', compact('cart_items'));
        }
        else
        {
            $cart_items = Cart::latest()->get();
            return view('cart.index', compact('cart_items'));
        }
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Categories::select("id","name")->get();
        $products = Products::select("id","name")->get();
        return view('cart.create', compact('categories','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'category_id'=>'required',
            'product_id'=>'required',
        ]);

         
        $cart = new Cart([
            'category_id' => $request->get('category_id'),
            'product_id' => $request->get('product_id'),
            'selected_by' => Auth::id(),
            'selected_date' => Carbon::parse(now()),
         ]);
         $cart->save();
         return redirect('/cart')->with('success', 'Product added to your Cart Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $cart = Cart::find($id);
        $categories = Categories::select("id","name")->get();
        $products = Products::select("id","name")->where('category_id',$cart->category_id)->get();
        return view('cart.edit', compact('cart','categories','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'category_id'=>'required',
            'product_id'=>'required',
        ]);

        $cart = Cart::find($id);
         
        $cart->selected_date =  Carbon::parse(now());
        $cart->category_id = $request->get('category_id');
        $cart->product_id = $request->get('product_id');
        $cart->selected_by = Auth::id();
           
        $cart->update();
        return redirect('/cart')->with('success', 'Cart Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cart = Cart::find($id);
        $cart->delete();

        return redirect('/cart')->with('success', 'Product Deleted From Your Cart Successfully!');
    }
}
