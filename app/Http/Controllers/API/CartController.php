<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\User;
use App\Models\Categories;
use App\Models\Products;
use Carbon\Carbon;
use Auth;
use Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentURL = $request->ip();
        if(\Auth::user()->is_permission == 0)
        {
            
            $cart_items = Cart::where('selected_by',Auth::id())->latest()->get();

            $results = $cart_items->map(function ($item, $key) use($currentURL){
                return [
                    "cart_id" => $item->id,
                    "selected_date" => isset($item->selected_date) ? $item->selected_date : "",
                    "category_id" => isset($item->category_id) ? $item->category_id : "",
                    "category_name" => isset($item->category->name) ? $item->category->name : "",
                    "product_id" => isset($item->product_id) ? $item->product_id : "",
                    "product_name" => isset($item->product->name) ? $item->product->name : "",
                    "selected_by_id" => isset($item->selected_by) ? $item->selected_by : "",
                    "selected_by_name" => isset($item->user->name) ? $item->user->name : "",
                    "product_image_path" => isset($item->product->image_path) ? $currentURL."/image/".$item->product->image_path : "",
                    "created_at" => isset($item->created_at) ? $item->created_at : "",
                    "updated_at" => isset($item->updated_at) ? $item->updated_at : "",
                    "deleted_at" => isset($item->deleted_at) ? $item->deleted_at : "",
                   
                ];
            }); 
            
            return response()->json([
                'status' => "success",
                'data' => $results
            ], 200);
        }
        else
        {
            
            $cart_items = Cart::latest()->get();

            $results = $cart_items->map(function ($item, $key) use($currentURL){
                return [
                    "cart_id" => $item->id,
                    "selected_date" => isset($item->selected_date) ? $item->selected_date : "",
                    "category_id" => isset($item->category_id) ? $item->category_id : "",
                    "category_name" => isset($item->category->name) ? $item->category->name : "",
                    "product_id" => isset($item->product_id) ? $item->product_id : "",
                    "product_name" => isset($item->product->name) ? $item->product->name : "",
                    "selected_by_id" => isset($item->selected_by) ? $item->selected_by : "",
                    "selected_by_name" => isset($item->user->name) ? $item->user->name : "",
                    "product_image_path" => isset($item->product->image_path) ? $currentURL."/image/".$item->product->image_path : "",
                    "created_at" => isset($item->created_at) ? $item->created_at : "",
                    "updated_at" => isset($item->updated_at) ? $item->updated_at : "",
                    "deleted_at" => isset($item->deleted_at) ? $item->deleted_at : "",
                   
                ];
            }); 
            
            return response()->json([
                'status' => "success",
                'data' => $results
            ], 200);
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
       
        $validator = Validator::make($request->all(), [
            'category_id'=>'required',
            'product_id'=>'required',
        ]);

        if($validator->fails()){
           
            return response()->json([
                "message" => "The given data was invalid.",
                "errors" => $validator->errors()
            ], 422);
  
        }

         
        $cart = new Cart([
            'category_id' => $request->get('category_id'),
            'product_id' => $request->get('product_id'),
            'selected_by' => Auth::id(),
            'selected_date' => Carbon::parse(now()),
         ]);
         $cart->save();
         
         return response()->json([
            'status' => "success",
            'message' => 'Product added to your Cart Successfully!'
         ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        $cart = Cart::find($id);
        $currentURL = $request->ip();

        if (!$cart) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sorry, cart with id ' . $id . ' cannot be found'
            ], 400);
        }

        $result = new Cart;
        
        $result->cart_id = $cart->id;
        $result->selected_date = $cart->selected_date;
        $result->category_id = $cart->category_id;
        $result->category_name = $cart->category->name;
        $result->product_id = $cart->product_id;
        $result->product_name = $cart->product->name;
        $result->selected_by_id = $cart->selected_by;
        $result->selected_by_name = $cart->user->name;
        $result->product_image_path = $currentURL."/image/".$cart->product->image_path;
        $result->created_at = $cart->created_at;
        $result->updated_at = $cart->updated_at;
        $result->deleted_at = $cart->deleted_at;

        return $result;
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
        $validator = Validator::make($request->all(), [
            'category_id'=>'required',
            'product_id'=>'required',
        ]);

        if($validator->fails()){
           
            return response()->json([
                "message" => "The given data was invalid.",
                "errors" => $validator->errors()
            ], 422);
  
        }

        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, cart with id ' . $id . ' can not be found'
            ], 400);
        }
         
        $cart->selected_date =  Carbon::parse(now());
        $cart->category_id = $request->get('category_id');
        $cart->product_id = $request->get('product_id');
        $cart->selected_by = Auth::id();
           
        $cart->update();
        
        return response()->json([
            'status' => "success",
            'message' => 'Cart Item Updated Successfully!'
         ], 200);
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
        
        if (!$cart) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sorry, cart item with id ' . $id . ' can not be found'
            ], 400);
        }

        $cart->delete();

        return response()->json([
            'status' => "success",
            'message' => 'Cart Item Deleted Successfully!'
        ], 200);
    }
}
