@extends('header')

@section('content')

<style>
    body {
        margin-top: 90px;
        font-family: Raleway;
    }

    .return {
        border-radius: 35px;
        width: fit-content;
        cursor: pointer;
        text-align: center;
        font-family: Raleway;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.5s;
        text-decoration: none;
        margin: 0 auto;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #DE6E1E;
        border: none;
        color: white;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-body text-center">
            <h3>Congratulations!</h3>
            <p>Your score will be displayed in the the results page as your teacher approve it </p>
        </div>
    </div>
    <a class="return" href="{{ route('student') }}">Return home</a>
</div>

<script type="text/javascript">
    document.title = 'Results';
</script>

@endsection
