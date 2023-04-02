<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Orders;
use App\User;
use App\Models\Categories;
use App\Models\Products;
use Carbon\Carbon;
use Auth;
use Illuminate\Notifications\Notification;
use App\Notifications\OrderNotifications\OrderPlaced;
use App\Notifications\OrderNotifications\OrderUpdated;
use App\Notifications\OrderNotifications\OrderCancelled;
use DB;
use Validator;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $currentURL = $request->ip();
        if(\Auth::user()->is_permission == 0)
        {
            $order_items = Orders::where('ordered_by',Auth::id())->latest()->paginate(10);

            $results = $order_items->map(function ($item, $key) use($currentURL){
                return [
                    "order_id" => $item->id,
                    "order_date" => isset($item->order_date) ? $item->order_date : "",
                    "category_id" => isset($item->category_id) ? $item->category_id : "",
                    "category_name" => isset($item->category->name) ? $item->category->name : "",
                    "product_id" => isset($item->product_id) ? $item->product_id : "",
                    "product_name" => isset($item->product->name) ? $item->product->name : "",
                    "ordered_by_id" => isset($item->ordered_by) ? $item->ordered_by : "",
                    "ordered_by_name" => isset($item->user->name) ? $item->user->name : "",
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
        else // If Admin then show all records
        {
            $order_items = Orders::latest()->paginate(10);

             $results = $order_items->map(function ($item, $key) use($currentURL){
                return [
                    "order_id" => $item->id,
                    "order_date" => isset($item->order_date) ? $item->order_date : "",
                    "category_id" => isset($item->category_id) ? $item->category_id : "",
                    "category_name" => isset($item->category->name) ? $item->category->name : "",
                    "product_id" => isset($item->product_id) ? $item->product_id : "",
                    "product_name" => isset($item->product->name) ? $item->product->name : "",
                    "ordered_by_id" => isset($item->ordered_by) ? $item->ordered_by : "",
                    "ordered_by_name" => isset($item->user->name) ? $item->user->name : "",
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

         
        $order = new Orders([
            'category_id' => $request->get('category_id'),
            'product_id' => $request->get('product_id'),
            'ordered_by' => Auth::id(),
            'order_date' => Carbon::parse(now()),
         ]);
         
         $order->save();
         
         $customer = User::where('id',$order->ordered_by)->first(); 
         $customer->notify(new OrderPlaced($order));
        
         return response()->json([
            'status' => "success",
            'message' => 'Order Placed Successfully!'
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
        $order = Orders::find($id);
        $currentURL = $request->ip();

        if (!$order) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sorry, order with id ' . $id . ' cannot be found'
            ], 400);
        }

        $result = new Orders;
        
        $result->order_id = $order->id;
        $result->order_date = $order->order_date;
        $result->category_id = $order->category_id;
        $result->category_name = $order->category->name;
        $result->product_id = $order->product_id;
        $result->product_name = $order->product->name;
        $result->ordered_by_id = $order->selected_by;
        $result->ordered_by_name = $order->user->name;
        $result->product_image_path = $currentURL."/image/".$order->product->image_path;
        $result->created_at = $order->created_at;
        $result->updated_at = $order->updated_at;
        $result->deleted_at = $order->deleted_at;

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

        $order = Orders::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, order with id ' . $id . ' can not be found'
            ], 400);
        }
         
        $order->order_date =  Carbon::parse(now());
        $order->category_id = $request->get('category_id');
        $order->product_id = $request->get('product_id');
        $order->ordered_by = Auth::id();
           
        $order->update();

        $customer = User::where('id',$order->ordered_by)->first(); 
        $customer->notify(new OrderUpdated($order));

        return response()->json([
            'status' => "success",
            'message' => 'Order Updated Successfully!'
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
        $order = Orders::find($id);
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, order with id ' . $id . ' can not be found'
            ], 400);
        }

        $order->delete();

        $customer = User::where('id',$order->ordered_by)->first(); 
        $customer->notify(new OrderCancelled($order));

        return response()->json([
            'status' => "success",
            'message' => 'Order has been Cancelled Successfully!'
        ], 200);
    }
}
