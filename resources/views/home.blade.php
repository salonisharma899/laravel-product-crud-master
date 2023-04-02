@extends('layouts.app')

@section('content')
@if($current_user->is_permission == 1)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul>  
                        
                        <li>
                            <a href="{{ route('registration') }}" >Tab Panel</a> 
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}" >Categories</a> 
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}" >Products</a> 
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}" >Cart</a> 
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}" >Orders</a> 
                        </li>
                        
                        <li>
                            <a href="{{ route('show_data') }}" >Orders with Datatable</a> 
                        </li>
                    </ul>    
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if($current_user->is_permission == 0)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul>
                        <li>
                            <a href="{{ route('cart.index') }}" >Cart</a> 
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}" >Orders</a> 
                        </li>
                    </ul>    
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
