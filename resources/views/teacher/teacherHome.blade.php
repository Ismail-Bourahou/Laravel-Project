@extends('header')

@section('content')

<style>
    .container {
        max-width: 70%;
        margin: 0 auto;
        padding: 20px;
    }

    .cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .card {
        border-radius: 18px;
        font-family: Raleway, sans-serif;
        padding: 20px;
        width: calc(33.33% - 1px);
        box-sizing: border-box;
        background-color: #070F29;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
        width: fit-content;
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
        font-family: Raleway, sans-serif;
        font-size: 28px;
        font-weight: bold;
        color: #070F29;
        text-align: center;
        margin-bottom: 20px;
    }

    .exam-title {
        font-size: 26px;
        font-weight: bold;
        margin: 0;
        text-align: left;
    }

    .exam-prop {
        margin: 5px 0;
        text-align: left;
        font-family: Poppins, sans-serif;
        font-size: 14px;
    }

    .exam-pass {
        text-decoration: none;
        background-color: #DE6E1E;
        color: white;
        margin-top: 20px;
        border-radius: 15px;
        padding: 10px 20px;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: fit-content;
        transition: background-color 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .exam-pass:hover {
        background-color: #c65a1a;
    }

    .clic {
        text-align: left;
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
        animation: fadeInUp 1s ease-out forwards;
    }

    .create {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        background-color: #DE6E1E;
        color: #fff;
        text-decoration: none;
        border-radius: 50%;
        transition: background-color 0.3s ease;
        font-family: Raleway, sans-serif;
        font-size: 30px;
        position: fixed;
        top: 90%;
        left: 92%;
    }

    .create:hover {
        background-color: #c65a1a;
    }

    .buttons {
        display: flex;
        margin-top: 15px;
    }

    .hat {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .but {
        text-decoration: none;
        background-color: #DE6E1E;
        color: white;
        border-radius: 15px;
        padding: 10px 20px;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: fit-content;
        transition: background-color 0.3s ease;
        position: relative;
        z-index: 2;
        cursor: pointer;
    }

    .delete {
        width: 20px;
        cursor: pointer;
    }

    #b2 {
        margin-left: 10px;
    }

    .but:hover {
        background-color: #c65a1a;
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 10px 15px;
        border: 1px solid #c3e6cb;
        border-radius: 4px;
        margin-bottom: 20px;
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

    .links-container {
        display: flex;
        justify-content: center;
        gap: 80px;
        margin-bottom: 30px;
    }

    .link-button {
        position: relative;
        padding: 10px 20px;
        font-family: Raleway;
        font-size: 16px;
        font-weight: 600;
        color: #070F29;
        text-decoration: none;
        transition: color 0.3s;
    }

    .link-button::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 100%;
        height: 2px;
        background-color: #EBA573;
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.3s ease;
    }

    .link-button:hover::after,
    .link-button.active::after {
        transform: scaleX(1);
        transform-origin: left;
    }

    .link-button:hover {
        color: #EBA573;
    }
</style>

@if(session()->has('success'))
    <div class="success-message">
        {{ session()->get('success') }}
    </div>
@endif


<div class="links-container">
    <a class="link-button" href="{{ route('teacher') }}">Exam List</a>
    <a class="link-button" href="{{ route('teacherStudents') }}">Students List</a>
</div>

<div class="container">

    <div class="cards-container">
        @foreach($exams as $exam)
            <div class="card" data-start="{{ $exam->date }}T{{ $exam->start_time }}" onmousemove="adjustOpacity(event)"
                onmouseleave="resetOpacity(event)">

                <div class="highlight"></div>
                <div class="clic">
                    <div class="hat">
                        <p class="exam-title">{{ $exam->title }}</p>
                        <form id="fo1-{{ $exam->id }}" action="{{ route('exam.destroy', ['exam' => $exam->id]) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <img class="delete" src="{{ asset('delet.png') }}" onclick="submition('fo1-{{ $exam->id }}')">
                        </form>
                    </div>
                    <p class="exam-prop">Subject: {{ $exam->subject->subject_name }}</p>
                    <p class="exam-prop">Date: {{ $exam->date }}</p>
                    <p class="exam-prop">Start time: {{ $exam->start_time }}</p>
                    <p class="exam-prop">End time: {{ $exam->end_time }}</p>
                    <p class="exam-prop">Type: {{ $exam->type }}</p>
                    <div class="buttons">
                        <a class="but edit" href="{{ route('exam.edit', ['exam' => $exam->id]) }}">Edit</a>
                        <a class="but results" id="b2"
                            href="{{ route('exam.details', ['examId' => $exam->id]) }}">Results</a>
                        <a class="but view-exam" id="b2" href="{{ route('voirApercu', ['examId' => $exam->id]) }}">View
                            Exam</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<a class="create" href="{{ route('exam') }}">+</a>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const currentLocation = window.location.href;
        const links = document.querySelectorAll('.link-button');

        links.forEach(link => {
            if (link.href === currentLocation) {
                link.classList.add('active');
            }
        });
    });
</script>

<script>
    document.title = 'Teacher\'s Exams';

    document.addEventListener('DOMContentLoaded', function () {
        const currentDateTime = new Date();
        const cards = document.querySelectorAll('.card');

        cards.forEach(card => {
            const startDateTimeString = card.getAttribute('data-start');
            const startDateTime = new Date(startDateTimeString);

            const editButton = card.querySelector('.edit');
            const resultsButton = card.querySelector('.results');
            const viewExamButton = card.querySelector('.view-exam');

            if (currentDateTime >= startDateTime) {
                editButton.style.display = 'none';
                resultsButton.style.display = 'flex';
            } else {
                resultsButton.style.display = 'none';
                editButton.style.display = 'flex';
            }

            viewExamButton.style.display = 'flex'; // Always display View Exam button
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
