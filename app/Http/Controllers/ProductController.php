<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Products::all();
        return view('products.index', compact('products'));
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
        return view('products.create', compact('categories'));
    }
    public function getProductPrice(Request $request)
    {
        $product_id = $request->product_id;
        $product = Products::select('id','price','image_path')->where('id',$product_id)->first();
        return $product;
    }
    //getProductsByCategory
    public function getProductsByCategory(Request $request)
    {
        $category_id = $request->category_id;
        $product = Products::where('category_id',$category_id)->get();
        return $product;
    }

    public function getProductsView(Request $request)
    {
        $category_id = $request->category_id;
        $product = Products::where('category_id',$category_id)->get();

        $html=view('productGrid',compact('product'))->render();

        if (count($product)>0) 
        {
            return response::json(['status'=>'success','data'=>$html]);
        } 
        else 
        {
            return response::json(['status'=>'fail','Nothing Found!!']);
        }
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
            'name'=>'required',
            'category_id'=>'required',
            'image'=>'required',
            'price'=>'required|numeric',
            'descryption'=>'required',

         ]);

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
         return redirect('/products')->with('success', 'Product Saved Successfully!');
        
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
        $categories = Categories::select("id","name")->get();
        $product = Products::find($id);
        return view('products.edit', compact('product','categories'));  
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
        
        $request->validate([
            'name'=>'required',
            'category_id'=>'required',
            'image'=>'required',
            'price'=>'required|numeric',
            'descryption'=>'required',

        ]);
        $product = Products::find($id);
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
        return redirect('/products')->with('success', 'Product Updated Successfully!');
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
        $product->delete();

        return redirect('/products')->with('success', 'Products Deleted Successfully!');
    }
}
