
@foreach($product->chunk(2) as $items)
<div class="row">
   @foreach($items as $item)
   <div class="col-sm-4 row-item img-container img-responsive">
      
        <img src="{{asset('image/').'/'.$item->image_path}}" alt="profile Pic" height="150" width="150" id="product_image" style="margin-top: 8px; ">
        
        <div class="text-section">
          <div class="text-container">
            Product Name : {{$item->name}}
          </div>
          <div class="text-container">  
            Product Category : {{$item->category->name}}
          </div>
          <div class="text-container">    
            Price : <span style='font-size:17px;'>&#8377;</span> {{$item->price}}
          </div>
        </div>
     
   </div>
   @endforeach
</div>
@endforeach

<br>



<!-- <div class="container-fluid" style="padding-left:40px;" id="product-list"> 
     
   <div class="row"> 
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
   </div>   

   <div class="row" style="clear:both;"></div>
   
   <div class="row"> 
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
   </div> 

   <div class="row" style="clear:both;"> </div>
   
   <div class="row"> 
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
      <div class="col-sm-4 row-item"></div>
   </div> 

</div> -->