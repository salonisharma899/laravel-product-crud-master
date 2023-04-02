@extends('base')

@section('main')
<div class="row">
  <div class="col-sm-12">
    @if(session()->get('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}  
      </div>
    @endif
  </div>

<div class="col-sm-12">
    <h1 class="display-8" style="margin-top:20px;">Products</h1>    
  <div alin="left" class="col-sm-24">  <a href="{{ route('products.create')}}" class="btn btn-primary">Add</a> </div>
  <table class="table table-striped" style="margin-top:40px;">
    <thead>
        <tr>
          <td>ID</td>
          <td>Product Name</td>
          <td>Product Image</td>
          <td>Category</td>
          <td>Price</td>
          <td colspan = 2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{$loop->index+1}}</td>
            <td>{{$product->name}}</td>
             <td><img src="{{asset('image/').'/'.$product->image_path}}" alt="profile Pic" height="70" width="70" id="product_image"></td>
            <td>{{$product->category->name}}</td>
            <td>{{$product->price}}</td>
            <td>
              <div>
                <div style="float:left;">
                  <a href="{{ route('products.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                </div>

                <div style="float:left;margin-left:5px;">
                  <form action="{{ route('products.destroy', $product->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                  </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
@endsection