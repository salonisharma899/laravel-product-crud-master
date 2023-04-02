@extends('base')

@section('main')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-8">Add A Product to Cart</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
       <form method="post" action="{{ route('cart.store') }}" >
          @csrf
        
          <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control select2" name='category_id' id='category_id'>
               @foreach($categories as $row)
                  <option value="{{$row->id}}" >{{$row->name}}</option>
                @endforeach 
            </select>
          </div>

          <div class="form-group">
            <label for="product_id">Product:</label>
            <select class="form-control select2" name='product_id' id='product_id'>
              
            </select>
          </div>

          <div class="form-group">    
              <label for="price">Product Price:</label>
              <input type="text" class="form-control" name="price" id='price' readonly />
          </div>

          <div class="form-group">
              <label for="product_image">Product Image:</label>
              <div class="col-sm-6 product_image_div">
                  <img src="{{URL::asset('')}}" alt="profile Pic" height="200" width="200" id="product_image">
              </div>
          </div>

               
          <button type="submit" class="btn btn-primary">Add Product To Cart</button>
      </form>
  </div>
</div>
</div>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>

 $(document).on('change', '#category_id', function (e) {

     var category_id = $('#category_id').find(":selected").val();
     $.ajax({
           url:"{{ url('getProductsByCategory')}}",
           type:"get",
           data:{'category_id':category_id},
           success: function(response)
           {
              // console.log(response);
              $("#product_id").empty();
              for (var i=0; i<response.length; i++) 
              {
                $("#product_id").append("<option value='"+response[i].id+"'>"+response[i].name+"</option>");
              }
           }
     }); 
 });   

 $(document).on('change', '#product_id', function (e) {

      var product_id = $('#product_id').find(":selected").val();
      $.ajax({
           url:"{{ url('getProductPrice')}}",
           type:"get",
           data:{'product_id':product_id},
           success: function(response)
           {
              // console.log(response.price);
               $('#price').val(response.price);
               var getUrl = "http://"+window.location.host+"/image/"+response.image_path;
               $(".product_image_div").html("");
               var strData = '<img src="'+getUrl+'" height="200" width="200">';
               $(".product_image_div").append(strData);
           }
      }); 
  });   

 

</script>