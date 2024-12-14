@extends('header')

@section('content')
<style>
    .home-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
    }

    .home-interface {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        animation: fadeIn 1.5s ease-in-out;
    }

    .image {
        width: 600px;
        opacity: 0;
        animation: slideIn 2s ease-in-out forwards;
    }

    .home-left {
        text-align: left;
        opacity: 0;
        animation: slideInText 1s ease-in-out forwards;
    }

    .home-title {
        margin-top: 0;
        font-size: 2.5em;
        /* animation: fadeInText 2s ease-in-out 1s forwards; */
        width: 400px;
    }

    .home-button {
        margin: 20px 0;
        padding: 12px 20px;
        background-color: #070F29;
        color: white;
        text-decoration: none;
        border-radius: 15px;
        display: inline-block;
        transition: all 0.3s ease;
        margin-left: 20%;
    }

    .home-button:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        0% {
            transform: translateX(100px);
            opacity: 0;
        }

        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInText {
        0% {
            transform: translateX(-100px);
            opacity: 0;
        }

        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeInText {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @media (max-width: 1200px) {
        .image {
            width: 500px;
        }

        .home-title {
            font-size: 2.2em;
            width: 370px;
        }
    }

    @media (max-height: 600px) {
        .image {
            width: 500px;
        }

        .home-title {
            font-size: 2.2em;
            width: 370px;
        }
    }

    @media (max-width: 970px) {
        .image {
            width: 400px;
        }

        .home-title {
            font-size: 2em;
            width: 350px;
        }

        .home-button {
            font-size: 14px;
            padding: 8px 18px;
        }
    }

    @media (max-height: 500px) {
        .image {
            width: 400px;
        }

        .home-title {
            font-size: 2em;
            width: 350px;
        }

        .home-button {
            font-size: 14px;
            padding: 8px 18px;
        }
    }

    @media (max-width: 880px) {
        .image {
            width: 300px;
        }

        .home-title {
            font-size: 1.7em;
            width: 300px;
        }

        .home-button {
            font-size: 14px;
            padding: 6px 16px;
        }
    }

    @media (max-height: 400px) {
        .image {
            width: 300px;
        }

        .home-title {
            font-size: 1.7em;
            width: 300px;
        }

        .home-button {
            font-size: 14px;
            padding: 6px 16px;
        }
    }
</style>
@if (session('success'))
    <div class="alert alert-success" style="font-family: Raleway;">
        {{ session('success') }}
    </div>
@endif

<div class="home-container">
    <div class="home-interface">
        <div class="home-left">
            <h1 class="home-title">
                The Future of University Exams
            </h1>
            <a class="home-button" href="{{ route('login') }}">
                Get Started
            </a>
        </div>
        <div class="home-image">
            <img class="image" src="{{ asset('education.jpg') }}">
        </div>
    </div>
</div>

@endsection
