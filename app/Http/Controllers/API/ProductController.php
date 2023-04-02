<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use Validator;




use Illuminate\Foundation\Validation\ValidatesRequests;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $products = Products::all();

        $currentURL = $request->ip();

        $results = $products->map(function ($item, $key) use($currentURL){
            return [
                "product_id" => $item->id,
                "product_name" => isset($item->name) ? $item->name : "",
                "product_descryption" => isset($item->descryption) ? $item->descryption : "",
                "product_category" => isset($item->category->name) ? $item->category->name : "",
                "product_price" => isset($item->price) ? $item->price : "",
                "product_image_path" => isset($item->image_path) ? $currentURL."/image/".$item->image_path : "",
            ];
        });  

        return response()->json([
            'status' => "success",
            'data' => $results
        ], 200);

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
            'name'=>'required',
            'category_id'=>'required',
            'image'=>'required',
            'price'=>'required|numeric',
            'descryption'=>'required',
        ]);

        if($validator->fails()){
           
            return response()->json([
                "message" => "The given data was invalid.",
                "errors" => $validator->errors()
            ], 422);
  
        }


        if($files=$request->file('image'))
        {
            $image_name=$files->getClientOriginalName();
            $files->move('image',$image_name);
            // $image_path = public_path('image\\' . $image_name);
        }    
        $product = new Products([
            'name' => $request->get('name'),
            'category_id' => $request->get('category_id'),
            //'image_path' => $image_path,
            'image_path' => $image_name,
            'price' => $request->get('price'),
            'descryption' => $request->get('descryption'),
        ]);
        $product->save();
         
         
        return response()->json([
            'status' => "success",
            'message' => 'Product Saved Successfully!'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $product = Products::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        $currentURL = $request->ip();

        $result = new Products;
        
        $result->product_id = $product->id;
        $result->product_name = $product->name;
        $result->product_descryption = $product->descryption;
        $result->product_category = $product->category->name;
        $result->product_price = $product->price;
        $result->product_image_path = $currentURL."/image/".$product->image_path;

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
            'name'=>'required',
            'category_id'=>'required',
            'image'=>'required',
            'price'=>'required|numeric',
            'descryption'=>'required',
        ]);

        if($validator->fails()){
           
            return response()->json([
                "message" => "The given data was invalid.",
                "errors" => $validator->errors()
            ], 422);
  
        }
       
        $product = Products::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' can not be found'
            ], 400);
        }
        
        $image_name = "";
        if($files=$request->file('image'))
        {
            $image_name=$files->getClientOriginalName();
            $files->move('image',$image_name);
            $image_path = public_path('image\\' . $image_name);
        }  
       
        $product->name =  $request->get('name');
        $product->category_id = $request->get('category_id');
        $product->image_path = $image_name;
        $product->price = $request->get('price');
        $product->descryption = $request->get('descryption');
           
        $product->update();
       
        
        return response()->json([
            'status' => "success",
            'message' => 'Product Updated Successfully!'
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
        $product = Products::find($id);
        
        if (!$product) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sorry, product with id ' . $id . ' can not be found'
            ], 400);
        }

        $product->delete();

        return response()->json([
            'status' => "success",
            'message' => 'Products Deleted Successfully!'
        ], 200);
    }

    public function getProductsByCategory(Request $request,$category_id)
    {
        $currentURL = $request->ip();
        $products = Products::where('category_id',$category_id)->get();
        // return $product;

        $results = $products->map(function ($item, $key) use($currentURL){
            return [
                "product_id" => $item->id,
                "product_name" => isset($item->name) ? $item->name : "",
                "product_descryption" => isset($item->descryption) ? $item->descryption : "",
                "product_category" => isset($item->category->name) ? $item->category->name : "",
                "product_price" => isset($item->price) ? $item->price : "",
                "product_image_path" => isset($item->image_path) ? $currentURL."/image/".$item->image_path : "",
            ];
        });  

        return response()->json([
            'status' => "success",
            'data' => $results
        ], 200);
    }
}
