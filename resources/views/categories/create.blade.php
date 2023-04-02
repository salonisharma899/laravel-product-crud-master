@extends('base')

@section('main')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-8">Add A Category</h1>
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
      <form method="post" action="{{ route('categories.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">    
              <label for="name">Category Name:</label>
              <input type="text" class="form-control" name="name"/>
          </div>
         
          <div class="form-group">
              <label for="descryption">Descryption:</label>
              <textarea class="form-control" name="descryption" id="descryption"></textarea>
          </div>
                              
          <button type="submit" class="btn btn-primary">Add Category</button>
      </form>
  </div>
</div>
</div>
@endsection