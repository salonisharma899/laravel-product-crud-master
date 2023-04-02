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
    <h1 class="display-8" style="margin-top:20px;">Orders</h1>    
  <div alin="left">  <a href="{{ route('orders.create')}}" class="btn btn-primary">Add</a> </div>
  <table class="table table-striped" style="margin-top:40px;">
    <thead>
        <tr>
          <td>ID</td>
          <td>Category</td>
          <td>Product Name</td>
          <td>Product Image</td>
          <td>Product Price</td>
          <td>Ordered Date</td>
          <td>Ordered By</td>
          <td>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($order_items as $order_item)
        <tr>
         
            <!-- <td>{{$loop->index+1}}</td> -->
            <td>{{$order_item->id}}</td>
            <td>{{$order_item->category->name}}</td>
            <td>{{$order_item->product->name}}</td>
            <td><img src="{{asset('image/').'/'.$order_item->product->image_path}}" alt="profile Pic" height="70" width="70" id="product_image"></td>
            <td>{{$order_item->product->price}}</td>
            <td>{{\Carbon\Carbon::parse($order_item->selected_date)->format("d-m-Y")}}</td>
            <td>{{ucfirst($order_item->user->name)}}</td>
        
            <td>
              <div>
                <div style="float:left;">
                  <a href="{{ route('orders.edit',$order_item->id)}}" class="btn btn-primary">Edit</a>
                </div>

                <div style="float:left;margin-left:5px;">
                  <form action="{{ route('orders.destroy', $order_item->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                  </form>
                </div>
              </div>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
  {{ $order_items->links() }}
<div>
</div>
@endsection