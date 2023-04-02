@extends('base') 
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-8">Update Product</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br /> 
        @endif
        <form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @method('PATCH') 
            @csrf
           

            <div class="form-group">    
              <label for="name">Product Name:</label>
              <input type="text" class="form-control" name="name" value="{{ $product->name }}" />
          </div>

          <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control select2" name='category_id' id='category_id'>
               @foreach($categories as $row)
                   @if($product->category_id == $row->id)
                      <option value="{{$row->id}}" selected>{{$row->name}}</option>
                   @else
                        <option value="{{$row->id}}" >{{$row->name}}</option>
                   @endif       
               @endforeach 
            </select>
          </div>

          <div class="form-group">    
              <label for="price">Product Price:</label>
              <input type="text" class="form-control" name="price" value={{ $product->price }} />
          </div>

          <div class="form-group">
              <label for="image">Image:</label>
              <input type="file" class="form-control" name="image" value={{ $product->image_path }} />
          </div>

          <div class="form-group">
              <label for="descryption">Descryption:</label>
              <textarea class="form-control" name="descryption" id="descryption"> {{ $product->descryption }} </textarea>
          </div>


            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection