<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use Datatables;
use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use App\Notifications\OrderNotifications\OrderPlaced;
use App\Notifications\OrderNotifications\OrderUpdated;
use App\Notifications\OrderNotifications\OrderCancelled;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if Non-Admin then show only those records that are created by currently logged-in user
        if(\Auth::user()->is_permission == 0)
        {
            $order_items = Orders::where('ordered_by',Auth::id())->latest()->paginate(5);
            return view('orders.index', compact('order_items'));
        }
        else // If Admin then show all records
        {
            $order_items = Orders::latest()->paginate(5);
            return view('orders.index', compact('order_items'));
        }
        
    }

    public function index_new()
    {
        // if Non-Admin then show only those records that are created by currently logged-in user
        if(\Auth::user()->is_permission == 0)
        {
            $order_items = Orders::where('ordered_by',Auth::id())->latest()->get();
        }
        else // If Admin then show all records
        {
            $order_items = Orders::latest()->get();
        }

        $results = $order_items->map(function ($item, $key) {
            return [
                "id" => $item->id,
                "category_name" => isset($item->category->name) ? $item->category->name : "",
                "product_name" => isset($item->product->name) ? $item->product->name : "",
                "product_image" => isset($item->product->image_path) ? $item->product->image_path : "",
                "product_price" => isset($item->product->price) ? $item->product->price : "",
                "order_date" => isset($item->order_date) ? Carbon::parse($item->order_date)->format("Y-m-d g:i A") : "",
                "ordered_by" => isset($item->user->name) ? ucfirst($item->user->name) : "",
            ];
        });                       
                       
        return Datatables::of($results)->setRowId('id')->make(true);
    }
    public function show_data()
    {
        return view('orders.list_products');
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
        return view('orders.create', compact('categories','products'));
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

         
        $order = new Orders([
            'category_id' => $request->get('category_id'),
            'product_id' => $request->get('product_id'),
            'ordered_by' => Auth::id(),
            'order_date' => Carbon::parse(now()),
         ]);
         
         $order->save();
         
         $customer = User::where('id',$order->ordered_by)->first(); 
         $customer->notify(new OrderPlaced($order));
        
         return redirect('/show_data')->with('success', 'Order Placed Successfully!');
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
        $order = Orders::find($id);
        $categories = Categories::select("id","name")->get();
        $products = Products::select("id","name")->where('category_id',$order->category_id)->get();
        return view('orders.edit', compact('order','categories','products'));
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

        $order = Orders::find($id);
         
        $order->order_date =  Carbon::parse(now());
        $order->category_id = $request->get('category_id');
        $order->product_id = $request->get('product_id');
        $order->ordered_by = Auth::id();
           
        $order->update();

        $customer = User::where('id',$order->ordered_by)->first(); 
        $customer->notify(new OrderUpdated($order));

        return redirect('/show_data')->with('success', 'Order Updated Successfully!');
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
        $order->delete();

        $customer = User::where('id',$order->ordered_by)->first(); 
        $customer->notify(new OrderCancelled($order));

        return redirect('/orders')->with('success', 'Your Order has been Cancelled Successfully!');

    }

    public function delete(Request $request)
    {
        //
        $id = $request->order_id;
        $order = Orders::find($id);
        $order->delete();

        $customer = User::where('id',$order->ordered_by)->first(); 
        $customer->notify(new OrderCancelled($order));

        //return redirect('/orders')->with('success', 'Your Order has been Cancelled Successfully!');

        echo 'Your Order has been Cancelled Successfully!';
        
    }
}
