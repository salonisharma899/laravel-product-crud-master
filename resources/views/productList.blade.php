<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Product List</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .row-item {
                border: 1px solid grey; 
                height: 250px; 
                width: 20%; 
                float:left; 
                margin-left: 15px; 
                box-shadow: 2px 2px #888888;
                background-color:lavender;
            }

            .img-container {
                text-align: center;
            }

            .text-container {
                color: white;
                margin-top: 6.5px;
                font-weight: bold;
                text-align: left;
                /* background-image: linear-gradient(to right, rgba(255,0,0,0), rgba(255,0,0,1)); */
                background-color:black;

            }
            .text-section{
                background-color:#92a8d1;;
            }

        </style>
    </head>
    <body>
        <h1 style="padding-left:42px;">Product List</h1>
        <div class="flex-center">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <br>
        
        <div class="container" style="padding-left:42px;">
            <div class="row">
                 <div class="form-group">
                    <label for="category_id">Categories:</label>
                    <select class="form-control select2" name='category_id' id='category_id'>
                        <option value="">Select Category</option>
                       @foreach($categories as $row)
                          <option value="{{$row->id}}" >{{$row->name}}</option>
                        @endforeach 
                    </select>
                  </div>
            </div>      
        </div>

        <br>
        

        

        <div class="container-fluid" style="padding-left:40px;" id="product-list"> 

       
        </div>

        
    </body>
</html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>

    $(document).on('change', '#category_id', function (e) {

        var category_id = $('#category_id').find(":selected").val();
        if(category_id == '')
        {
            $('#product-list').html(""); 
        }
        else
        {
            $.ajax({
                   url:"{{ url('getProductsView')}}",
                   type:"get",
                   data:{'category_id':category_id},
                   success: function(response)
                   {
                      $('#product-list').html(response.data); 
                   }
            }); 
        }
        
    }); 

</script>
