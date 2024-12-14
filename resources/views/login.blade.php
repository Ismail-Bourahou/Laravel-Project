@extends('header')

@section('content')

<div class="signup-page">
    <div class="signup-title">
        Log In
    </div>
    <div class="signup-formulaire">

        @if ($errors->has('auth'))
            <div class="alert-login" style="font-family: Raleway;">
                {{ $errors->first('auth') }}
            </div>
        @endif

        <form class="signup-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="first-inputs">
                <input class="id-input" type="text" placeholder="ID" name="id">
            </div>
            <div class="third-inputs">
                <input class="password-input" type="password" placeholder="Passwrod" name="password">
            </div>
            <button type="submit" class="signup-page-button">
                Log In
            </button>
            <div class="signup-message">
                Don't have an account?
                <a href="{{route('signup')}}" class="signup-message-login">
                    Sign Up
                </a>
            </div>
        </form>


    </div>
</div>

<script language='javascript' type='text/javascript'>
    function DisableBackButton() {
        window.history.forward()
    }
    DisableBackButton();
    window.onload = DisableBackButton;
    window.onpageshow = function (evt) { if (evt.persisted) DisableBackButton() }
    window.onunload = function () { void (0) }
</script>
<script>
    document.title = 'Log In';
</script>
@endsection
