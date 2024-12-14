@extends('header')

@section('content')

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        font-family: Raleway;
        font-size: 12px;
    }

    .question-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .question-card {
        border-radius: 18px;
        font-family: Raleway, sans-serif;
        padding: 20px;
        width: 100%;
        box-sizing: border-box;
        background-color: #070F29;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .question-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .question-title {
        font-size: 26px;
        font-weight: bold;
        margin: 0;
        text-align: left;
        margin-bottom: 10px;
    }

    .option-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .option-list li {
        font-family: Poppins, sans-serif;
        font-size: 14px;
        margin: 10px 0;
    }

    .correct {
        color: rgb(98, 215, 98);
    }

    .incorrect {
        color: red;
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

    .question-card {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .question-card .highlight {
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

    h1{
        margin-bottom: 30px;
    }
    h1::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background-color: #DE6E1E;
        margin: 10px auto 0;
        border-radius: 2px;
    }
</style>

<div class="container">
    <h1> {{ $student->firstname }} {{ $student->lastname }}'s {{ $exam->title }} Details</h1>

    <div class="question-container">
        @foreach($questions as $question)
            <div class="question-card" onmousemove="adjustOpacity(event)" onmouseleave="resetOpacity(event)">
                <div class="highlight"></div>
                <h2 class="question-title">{{ $question->txt_question }}</h2>
                <ul class="option-list">
                    @foreach($question->Options as $option)
                        @php
                            $isCorrect = $option->is_correct;
                            $isSelected = isset($studentAnswers[$question->id]) && $studentAnswers[$question->id]->pluck('option_id')->contains($option->id);
                            $optionClass = '';

                            if ($isSelected && $isCorrect) {
                                $optionClass = 'correct';
                            } elseif ($isSelected && !$isCorrect) {
                                $optionClass = 'incorrect';
                            } elseif (!$isSelected && $isCorrect) {
                                $optionClass = 'correct';
                            }
                        @endphp

                        <li class="{{ $optionClass }}">
                            <input type="radio" disabled {{ $isSelected ? 'checked' : '' }}>
                            {{ $option->txt_option }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.question-card');

        cards.forEach(card => {
            card.addEventListener('mousemove', adjustOpacity);
            card.addEventListener('mouseleave', resetOpacity);
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
