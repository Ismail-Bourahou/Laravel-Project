@extends('header')

@section('content')

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        font-family: Raleway;
    }

    .student {
        font-family: Raleway;
        font-size: 20px;
        color: #070F29;
        text-align: center;
        margin-bottom: 30px;
    }

    .exam-card {
        border-radius: 18px;
        font-family: Raleway, sans-serif;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #070F29;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
    }

    .exam-card p{
        margin-left: 100px;
    }

    .exam-card:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .exam-info {
        font-family: Raleway, sans-serif;
        font-size: 14px;
    }


    .student::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background-color: #DE6E1E; /* Orange underline */
        margin: 10px auto 0;
        border-radius: 2px;
    }
</style>

<div class="container">
    <h1 class="student">{{ $student->firstname }} {{ $student->lastname }}'s Passed Exams</h1>

    @if($passedExams->isEmpty())
        <p>No passed exams found for this student.</p>
    @else
        @foreach($passedExams as $passedExam)
            <div class="exam-card">
                <p class="exam-info"><strong>Exam Title:</strong> {{ $passedExam->exam->title }}</p>
                <p class="exam-info"><strong>Date Passed:</strong> {{ $passedExam->created_at->format('Y-m-d') }}</p>
                <p class="exam-info"><strong>Grade:</strong> {{ $passedExam->grade }} / {{ $passedExam->score }}</p>
            </div>
        @endforeach
    @endif
</div>

@endsection
