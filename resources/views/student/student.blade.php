@extends('header')

@section('content')

<style>
    body {
        /* margin-top: 120px; */
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }

    .cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 30px;
    }

    .card {
        position: relative;
        border-radius: 8px;
        width: calc(33.33% - 20px);
        box-sizing: border-box;
        background-color: #070F29; /* Orange background */
        text-decoration: none;
        color: white; /* White text color */
        transition: transform 0.3s, background-color 0.3s, box-shadow 0.3s;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card:hover {
        transform: translateY(-10px);
        background-color: #c65a1a; /* Blue color on hover */
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .card-content {
        padding: 20px;
        text-align: center;
    }

    .card p {
        margin: 5px 0;
        font-size: 16px;
    }

    .subject-list {
        font-family: 'Raleway', sans-serif;
        font-size: 20px;
        font-weight: bold;
        color: #070F29;
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }

    .subject-list::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background-color: #DE6E1E; /* Orange underline */
        margin: 10px auto 0;
        border-radius: 2px;
    }

    .subject-name {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    @media (max-width: 800px) {
        .card {
            width: calc(50% - 20px);
        }
    }

    @media (max-width: 600px) {
        .card {
            width: 100%;
        }
    }
</style>

<div class="container">
    <p class="subject-list">Subjects List</p>
    <div class="cards-container">
        @foreach($subjects as $subject)
        <a class="card" href="{{ route('showExams', ['subject_id' => $subject->id]) }}">
            <div class="card-content">
                <p class="subject-name">{{ $subject->subject_name }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<script>
    document.title = 'Subjects';
</script>

@endsection
