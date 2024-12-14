@extends('header')

@section('content')

<div class="signup-page">
    <div class="signup-title" style="text-align:center;">
        Change Password
    </div>
    <div class="signup-formulaire">

        @if ($errors->has('auth'))
            <div class="alert-login" style="font-family: Raleway;">
                {{ $errors->first('auth') }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert-success" style="font-family: Raleway;">
                {{ session('status') }}
            </div>
        @endif

        <form class="signup-form" method="POST" action="{{ route('new.password') }}">
            @csrf
            <div class="first-inputs">
                <input class="password-input" type="password" placeholder="Current Password" name="password">
            </div>
            <div class="second-inputs">
                <input class="password-input" type="password" placeholder="New Password" name="new-password">
            </div>
            <div class="third-inputs">
                <input class="password-input" type="password" placeholder="Confirm Password" name="confirm-password">
            </div>
            <button type="submit" class="signup-page-button">
                Change Password
            </button>
        </form>

    </div>
</div>

<script>
    document.title = 'Change Password';
</script>
@endsection
