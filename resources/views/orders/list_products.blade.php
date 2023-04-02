@extends('layouts.app')
@section('content')
<html lang="en">
<head>
    <title>Wish List</title>
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">   -->
    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
</head>
<body>
   <div class="container" style="margin-top:20px;">
      <h2>Wish List</h2>
      <div class="col-sm-12">
        @if(session()->get('success'))
          <div class="alert alert-success">
            {{ session()->get('success') }}  
          </div>
        @endif
      </div>
      <div alin="right" style="margin-top:5px;">  <a href="{{ route('orders.create')}}" class="btn btn-primary">Place A New Order</a> </div>
      <div style="margin-top:10px;">
      <table class="table table-bordered" id="yajra_table">
         <thead>
            <tr>
               <th>Id</th>
               <th>Category</th>
               <th>Product Name</th>
               <th>Product Image</th>
               <th>Product Price</th>
               <th>Order Date</th>
               <th>Ordered By</th>
               <th >Actions</th>
            </tr>
         </thead>
      </table>
    </div>
   </div>
  
   <script>
     $(function() {
           $('#yajra_table').DataTable({
           processing: true,
           serverSide: true,
           ajax: '{{ url('index_new') }}',
           columns: [

                    { data: 'id', name: 'id' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'product_image', name: 'product_image',
                        render: function( data, type, full, meta ) {
                          var getUrl = "http://"+window.location.host+"/image/"+data;
                          return "<img src='"+getUrl+"'  height=\"70\" width=\"70\" />";
                        }
                    },
                    { data: 'product_price', name: 'product_price' ,
                        render: function( data, type, full, meta ) {
                          var Rs = "<i style='font-size:14px' class='fa'>&#xf156;</i>";
                          return Rs+" "+data;
                        }
                    },
                    { data: 'order_date', name: 'order_date' },
                    { data: 'ordered_by', name: 'ordered_by' },
                    { data: 'id', name: 'id', orderable: false,
                        render: function( data, type, full, meta ) {
                          var getEditUrl = "http://"+window.location.host+"/orders/"+data+"/edit";
                          $action_buttons =  "<div><div style='float:left;'><a href='"+getEditUrl+"' class='btn btn-success '>Edit</a></div>";

                          
                          $action_buttons += "<div style='float:left;margin-left:5px;'><button class='btn btn-danger delete-order' data-order-id='"+data+"'>Delete</button></div></div>";
                          
                          return $action_buttons;
                        }
                    }
                 ]
        });
     });
        
     
     $(document).on('click', '.delete-order', function (e) {
        
        if(confirm("Are you sure you want to DELETE this order?")){
            var order_id = $(this).data('order-id');
            $.ajax({
                   url:"{{ route('deleteOrder')}}",
                   type:"post",
                   data:{'order_id':order_id, "_token": "{{ csrf_token() }}"},
                   success: function(response)
                   {
                        if ( $.fn.dataTable.isDataTable( '#yajra_table' ) ) {
                            table = $('#yajra_table').DataTable();
                            table.ajax.reload( null, false ); // user paging is not reset on reload
                            alert(response);
                        }
                   }
           });
        }
        else{
             return false;
        }       
        
     }); 
     

   </script>
 </body>
</html>
@endsection