@extends('base') 
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-8">Update User</h1>

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
        <form method="post" action="{{ route('users.update', $user->id) }}">
            @method('PATCH') 
            
            @csrf
           
          <div class="form-group">    
              <label for="first_name">User Price:</label>
              <input type="text" class="form-control" name="name" id='name' value={{$user->name}} />
          </div>

          <div class="form-group">    
              <label for="first_name">User Email:</label>
              <input type="text" class="form-control" name="email" id='email' value={{$user->email}} />
          </div>

          <div class="form-group">
            <label for="last_name">Role:</label>
            <select class="form-control select2" name='is_permission' id='is_permission'>
               @foreach($roles as $key=>$value)
                  @if($user->is_permission ==  $key)
                    <option value="{{$key}}" selected>{{$value}}</option>
                  @else
                    <option value="{{$key}}">{{$value}}</option>
                  @endif
               @endforeach 
            </select>
          </div>

        
         

        <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection

