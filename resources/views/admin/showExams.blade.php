@extends('header')

@section('content')

<link rel="stylesheet" href="{{asset('css/admin/showExams.css')}}">

@if(session()->has('success'))
    <div class="success-message">
        {{ session()->get('success') }}
    </div>
@endif

<div class="container">
    <h1 class="exams">Exams</h1>

    <div class="cards-container">
        @foreach($exams as $exam)
            <div class="card" onmousemove="adjustOpacity(event)" onmouseleave="resetOpacity(event)">
                <div class="highlight"></div>
                <div class="clic">
                    <div class="hat">
                        <p class="exam-title">{{ $exam->title }}</p>

                    </div>
                    <p class="exam-prop">Subject: {{ $exam->subject->subject_name }}</p>
                    <p class="exam-prop">Date: {{ $exam->date }}</p>
                    <p class="exam-prop">Start time: {{ $exam->start_time }}</p>
                    <p class="exam-prop">End time: {{ $exam->end_time }}</p>
                    <p class="exam-prop">Type: {{ $exam->type }}</p>
                    <div class="buttons">
                        <a class="but butt" id="b2" href="{{ route('exam.detail', ['examId' => $exam->id]) }}">Results</a>
                        <a class="but" id="b2" href="{{ route('voirAp', ['examId' => $exam->id]) }}">View Exam</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.title = 'Teacher\'s Exams';

    document.addEventListener('DOMContentLoaded', function () {
        const currentDateTime = new Date();
        const cards = document.querySelectorAll('.card');

        cards.forEach(card => {
            const startDateTimeString = card.getAttribute('data-start');
            const startDateTime = new Date(startDateTimeString);
            const editButton = card.querySelector('.edit');
            const showDetailsButton = card.querySelector('.butt');

            if (currentDateTime >= startDateTime) {
                editButton.style.display = 'none';
                showDetailsButton.style.display = 'flex';
            } else {
                showDetailsButton.style.display = 'none';
            }
        });
    });

    function submition(formId) {
        var forma = document.getElementById(formId);
        forma.submit();  // Submits the form
    }

    function adjustOpacity(event) {
        const card = event.currentTarget;
        const rect = card.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        const highlight = card.querySelector('.highlight');
        highlight.style.opacity = 1;
        highlight.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 60%)`;
    }

    function resetOpacity(event) {
        const card = event.currentTarget;
        const highlight = card.querySelector('.highlight');
        highlight.style.opacity = 0;
    }
</script>

@endsection
