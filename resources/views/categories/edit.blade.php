@extends('base') 
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-8">Update a Category</h1>

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
        <form method="post" action="{{ route('categories.update', $categories->id) }}">
            @method('PATCH') 
            
            @csrf
           

          <div class="form-group">    
              <label for="name">Category Name:</label>
              <input type="text" class="form-control" name="name" value="{{ $categories->name }}" />
          </div>

        
          <div class="form-group">
              <label for="descryption">Descryption:</label>
              <textarea class="form-control" name="descryption" id="descryption"> {{ $categories->descryption }} </textarea>
          </div>

        <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection