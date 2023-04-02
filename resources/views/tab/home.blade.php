@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <ul class="nav nav-tabs" role="tablist" id="main-menu">
            <li class="nav-item">
                <a class="nav-link active" data-user-type="admin" data-toggle="tab" href="#tabs-1" role="tab">Admin Registration</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-user-type="subAdmin" data-toggle="tab" href="#tabs-2" role="tab">Sub Admin Registration</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-user-type="user" data-toggle="tab" href="#tabs-3" role="tab">User Registartion</a>
            </li>
        </ul><!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane " id="tabs-1" role="tabpanel">

            </div>
            <div class="tab-pane" id="tabs-2" role="tabpanel">

            </div>
            <div class="tab-pane" id="tabs-3" role="tabpanel">

            </div>
        </div>
        <div class="active col-md-8" id="registrationForm" style="display:none; margin-top:40px;">


        <div class="card" style="border-color: #286090;">
                <div class="card-header" style="background-color:#286090; border-color: #2e6da4; color:white;">
                    <span id="header"></span>
                </div>
                <div class="card-body" style="font-size: 20px;">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <input id="type" type="hidden" name="type">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

</html>

<script>
    $(document).on('click', '.nav-link', function(e) {
        var usertype = $(this).data('user-type');
        var registrationForm = $("#registrationForm");

        //admin
        if (usertype == 'admin') {
            $("#header").text("Admin Registration");
            $('tabs-1').html(registrationForm);
            registrationForm.show();
            $('#type').val(usertype);
        }
        //subAdmin
        if (usertype == 'subAdmin') {
            $("#header").text("Sub Admin Registration");
            $('tabs-2').html(registrationForm);
            registrationForm.show();
            $('#type').val(usertype);
        }
        //user
        if (usertype == 'user') {
            $("#header").text("User Registration");
            $('tabs-3').html(registrationForm);
            registrationForm.show();
            $('#type').val(usertype);
        }
    });
</script>
@endsection