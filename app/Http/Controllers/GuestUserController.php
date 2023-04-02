<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;

class GuestUserController extends Controller
{
    //
    public function productListView()
    {
        //
        $categories = Categories::select("id","name")->get();
        return view('productList', compact('categories'));
    }
}
