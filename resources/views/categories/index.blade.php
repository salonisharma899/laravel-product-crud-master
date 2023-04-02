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
    <h1 class="display-8" style="margin-top:20px;">Categories</h1>    
  <div alin="left">  <a href="{{ route('categories.create')}}" class="btn btn-primary">Add</a> </div>
  <table class="table table-striped" style="margin-top:40px;">
    <thead>
        <tr>
          <td>ID</td>
          <td>Name</td>
          <td>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{$loop->index+1}}</td>
            <td>{{$category->name}}</td>
        
            <td>
              <div>
                <div style="float:left;">
                  <a href="{{ route('categories.edit',$category->id)}}" class="btn btn-primary">Edit</a>
                </div>

                <div style="float:left;margin-left:5px;">
                  <form action="{{ route('categories.destroy', $category->id)}}" method="post">
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
<div>
</div>
@endsection