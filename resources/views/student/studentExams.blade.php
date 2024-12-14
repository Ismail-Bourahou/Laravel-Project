@extends('header')

@section('content')

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .card {
        border-radius: 18px;
        font-family: Raleway, sans-serif;
        padding: 20px;
        width: calc(33.33% - 20px);
        box-sizing: border-box;
        background-color: #070F29;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 600px) {
        .card {
            width: calc(50% - 20px);
        }
    }

    .exams {
        font-family: 'Raleway', sans-serif;
        font-size: 20px;
        font-weight: bold;
        color: #070F29;
        text-align: center;
        margin-bottom: 30px;
        position: relative;
    }

    .exams::after {
        content: '';
        display: block;
        width: 30px;
        height: 4px;
        background-color: #DE6E1E;
        margin: 10px auto 0;
        border-radius: 2px;
    }

    .exam-title {
        font-size: 26px;
        font-weight: bold;
        margin: 0;
        text-align: center;
        margin-bottom: 20px;
    }

    .exam-prop {
        margin: 5px 0;
        text-align: center;
        font-family: Poppins, sans-serif;
        font-size: 14px;
    }

    .exam-pass, .exam-result {
        text-decoration: none;
        background-color: #DE6E1E;
        color: white;
        margin-top: 20px;
        border-radius: 15px;
        padding: 10px 20px;
        margin-left: 40px;
        font-size: 15px;
        width: fit-content;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .exam-pass {
        margin-left: 67px;
    }

    .exam-pass.disabled {
        background-color: gray;
        cursor: not-allowed;
    }

    .exam-pass:hover:not(.disabled), .exam-result:hover {
        background-color: #c65a1a;
    }

    .clic {
        text-align: center;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .card .highlight {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 60%);
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.1s ease;
    }
</style>

@if(session()->has('status'))
    <div class="status-message">
        {{ session()->get('status') }}
    </div>
@endif

<div class="container">
    <p class="exams">Exams</p>

    <div class="cards-container">
        @foreach($exams as $exam)
            <div class="card" onmousemove="adjustOpacity(event)" onmouseleave="resetOpacity(event)">
                <div class="highlight"></div>
                <div class="clic">
                    <p class="exam-title">{{ $exam->title }}</p>
                    <p class="exam-prop">Date: {{ $exam->date }}</p>
                    <p class="exam-prop"> Start time: {{ $exam->start_time }}</p>
                    <p class="exam-prop"> End time: {{ $exam->end_time }}</p>
                    <p class="exam-prop">Type: {{ $exam->type }}</p>
                    <a class="exam-pass" href="{{ route('enter.exam.code', ['exam_id' => $exam->id]) }}" data-start="{{ $exam->date }}T{{ $exam->start_time }}" data-end="{{ $exam->date }}T{{ $exam->end_time }}">Pass</a>
                    <a class="exam-result" href="{{ route('studentExamGrade', ['exam_id' => $exam->id]) }}" style="display: none;">Show Result</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.title = 'Exams';

    document.addEventListener('DOMContentLoaded', function() {
        const passButtons = document.querySelectorAll('.exam-pass');
        const resultButtons = document.querySelectorAll('.exam-result');
        const currentDateTime = new Date();

        passButtons.forEach((button, index) => {
            const startDateTimeString = button.getAttribute('data-start');
            const startDateTime = new Date(startDateTimeString);
            const endDateTimeString = button.getAttribute('data-end');
            const endDateTime = new Date(endDateTimeString);

            if (currentDateTime >= endDateTime) {
                button.style.display = 'none';
                resultButtons[index].style.display = 'flex';
            } else if (currentDateTime >= startDateTime) {
                button.classList.remove('disabled');
                button.style.display = 'flex';
            } else {
                button.classList.add('disabled');
                button.style.pointerEvents = 'none';
                button.style.display = 'flex';
                resultButtons[index].style.display = 'none';
            }
        });
    });

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
