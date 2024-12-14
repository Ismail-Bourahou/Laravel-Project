@extends('header')

@section('content')

<style>
    .container {
        text-align: center;
        padding: 0 70px;
    }

    .title {
        font-family: Raleway;
    }

    .question-container {
        padding: 10px 0;
        text-align: left;
    }

    .exam-head {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .qst-ipt {
        width: 40%;
        height: 40px;
        border: 1px solid #DE6E1E;
        border-radius: 20px;
        padding: 0 25px;
        font-family: Raleway;
        font-size: 14px;
        transition: all 0.5s;

    }

    .score-ipt:focus,
    .qst-ipt:focus {
        border-color: #DE6E1E;
        outline: none;
        box-shadow: 1px 1px 10px #DE6E1E;
    }

    .score-ipt {
        width: 30px;
        padding: 0;
        border: 1px solid #DE6E1E;
        border-radius: 15px;
        height: 40px;
        padding: 0 10px;
        transition: all 0.5s;
        font-family: Poppins;
    }

    .score-label {
        font-family: Raleway;
        font-weight: 600;
    }

    .btns {
        margin-left: 20px;
    }

    .opt-btn,
    .dlt-btn,
    .add-qst {
        height: 40px;
        border: 1px solid #070F29;
        border-radius: 20px;
        padding: 0 20px;
        background-color: transparent;
        transition: all 0.5s;
        font-family: Raleway;
        font-size: 14px;
        cursor: pointer;
        color: #DE6E1E;
    }

    .opt-btn:hover,
    .dlt-btn:hover,
    .add-qst:hover {
        background-color: #070F29;
        color: white;
    }

    .note {
        margin: 0 20px;
    }

    .opt-btn {}

    .dlt-opt {}

    .options-container {}

    .opt-ipt {
        border: 1px solid #070F29;
        border-radius: 15px;
        height: 40px;
        padding: 0 20px;
        width: 40%;
        margin: 10px 0;
        font-family: Raleway;
        transition: all 0.5s;
    }

    .opt-ipt:focus {
        border-color: #070F29;
        outline: none;
        box-shadow: 1px 1px 10px #070F29;
    }

    .opt-dlt {
        width: 20px;
        cursor: pointer;
    }

    .opt-sec {
        width: 44%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .opt-true {}

    .opt-label {
        font-family: Raleway;
        font-weight: 600;
    }

    .opt-check {}

    .qst-head {
        margin: 0;
    }

    .finish {
        height: 40px;
        padding: 0 20px;
        border: 1px solid #070F29;
        border-radius: 20px;
        background-color: #070F29;
        color: white;
        font-family: Raleway;
        cursor: pointer;
    }

    .add-qst {
        position: fixed;
        left: 87%;
        top: 90%;
    }
</style>

<div class="container">
    <h1 class="title">Modify your questions</h1>

    <form action="{{ route('updateQuestions') }}" method="POST">
        @csrf
        <div class="qst-head">
            <h2 class="qst-title">Questions</h2>
            <button class="finish" type="submit">Save & Exit</button>
        </div>
        <input type="hidden" name="exam_id" value="{{ session('exam_id') }}">
        <div id="questions-container">
            @foreach($questions as $question)
                <div class="question-container" data-question-id="{{ $question->id }}">
                    <div class="exam-head">
                        <input type="hidden" name="questions[{{ $question->id }}][id]" value="{{ $question->id }}">
                        <input placeholder="Question" class="qst-ipt" type="text"
                            name="questions[{{ $question->id }}][txt_question]" value="{{ $question->txt_question }}"
                            required>
                        @if ($exam->score)
                            <div class="note">
                                <label class="score-label" for="grade" style="display: none;">Score</label>
                                <input class="score-ipt" type="number"
                                    name="questions[{{ $question->id }}][grade]" style="display: none;"
                                    value="{{ $question->grade }}">
                            </div>
                        @else
                            <div class="note">
                                <label class="score-label" for="grade">Score</label>
                                <input class="score-ipt" type="number" name="questions[{{ $question->id }}][grade]"
                                    value="{{ $question->grade }}">
                            </div>


                        @endif
                        <div class="btns">
                            <button class="opt-btn" type="button" onclick="addOption(this)">Add Option</button>
                            <button class="dlt-btn" type="button" onclick="deleteQuestion(this)">Delete Question</button>
                        </div>

                    </div>

                    <div class="options-container">
                        @foreach($question->options as $option)
                            <section class="opt-sec" data-option-id="{{ $option->id }}">
                                <input placeholder="Option" class="opt-ipt" type="text"
                                    name="questions[{{ $question->id }}][options][{{ $option->id }}][txt_option]"
                                    value="{{ $option->txt_option }}" required>
                                <div class="opt-true">
                                    <label class="opt-label" for="options">True</label>
                                    <input class="opt-check" type="checkbox"
                                        name="questions[{{ $question->id }}][options][{{ $option->id }}][is_correct]" value="1"
                                        {{ $option->is_correct ? 'checked' : '' }}>
                                </div>

                                <img class="opt-dlt" src="{{ asset('delet.png') }}" onclick="removeOption(this)">
                            </section>

                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <button class="add-qst" type="button" onclick="addQuestion()">Add Question</button>

    </form>
</div>

<script>
    document.title = 'Exam\'s Questions';
    let questionIndex = {{ count($questions) }}; // Initialise l'index de la question avec le nombre de questions existantes

    function addQuestion() {
        questionIndex++;
        const questionsContainer = document.getElementById('questions-container');

        const questionContainer = document.createElement('div');
        questionContainer.classList.add('question-container');
        questionContainer.setAttribute('data-question-id', `new_${questionIndex}`);

        questionContainer.innerHTML = `
        <div class="exam-head">
            <input placeholder="Question" class="qst-ipt" type="text"
                name="questions[new_${questionIndex}][txt_question]" required>


            @if ($exam->score)
                <label for="grade" style="display: none;">Note:</label>
                <input type="number" name="questions[new_${questionIndex}][grade]" style="display: none;">

            @else
                <div class="note">
                    <label class="score-label" for="grade">Note:</label>
                    <input class="score-ipt" type="number" name="questions[new_${questionIndex}][grade]">
                </div>
            @endif
            <div class="btns">
                <button class="opt-btn" type="button" onclick="addOption(this)">Add Option</button>
                <button class="dlt-btn" type="button" onclick="deleteQuestion(this)">Delete Question</button>
            </div>
        </div>

        <div class="options-container">
            <section class="opt-sec">
                <input placeholder="Option" class="opt-ipt" type="text" name="questions[new_${questionIndex}][options][0][txt_option]" required>
                <div class="opt-true">
                    <label class="opt-label" for="options">True</label>
                    <input type="checkbox" name="questions[new_${questionIndex}][options][0][is_correct]" value="1">
                </div>
                <img class="opt-dlt" src="{{ asset('delet.png') }}" onclick="removeOption(this)">
            </section>

            <section class="opt-sec">
                <input placeholder="Option" class="opt-ipt" type="text" name="questions[new_${questionIndex}][options][0][txt_option]" required>
                <div class="opt-true">
                    <label class="opt-label" for="options">True</label>
                    <input type="checkbox" name="questions[new_${questionIndex}][options][0][is_correct]" value="1">
                </div>
                <img class="opt-dlt" src="{{ asset('delet.png') }}" onclick="removeOption(this)">
            </section>

        </div>
        `;

        questionsContainer.appendChild(questionContainer);
    }

    function addOption(button) {
        const questionContainer = button.closest('.question-container');
        const optionsContainer = questionContainer.querySelector('.options-container');
        const newOptionIndex = optionsContainer.querySelectorAll('section').length;

        const questionId = questionContainer.getAttribute('data-question-id');

        const newOption = document.createElement('section');
        newOption.setAttribute('class', 'opt-sec');
        newOption.innerHTML = `
            <input class="opt-ipt" placeholder="Option" type="text" name="questions[${questionId}][options][${newOptionIndex}][txt_option]" required>
            <div class="opt-true">
                <label class="opt-label" for="options">True</label>
                <input class="opt-check" type="checkbox" name="questions[${questionId}][options][${newOptionIndex}][is_correct]" value="1">
            </div>
            <img class="opt-dlt" src="{{ asset('delet.png') }}" onclick="removeOption(this)">
        `;

        optionsContainer.appendChild(newOption);
    }

    function removeOption(button) {
        const optionToRemove = button.closest('section');
        optionToRemove.remove();
    }



    function deleteQuestion(button) {
        const questionToRemove = button.closest('.question-container');
        const questionId = questionToRemove.getAttribute('data-question-id');

        // Ajouter un champ caché pour marquer la question pour suppression
        if (!questionId.startsWith('new_')) {
            const deletedQuestionsContainer = document.getElementById('deleted-questions');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_questions[]';
            input.value = questionId;
            deletedQuestionsContainer.appendChild(input);
            console.log(`Question ${questionId} marquée pour suppression`);
        }

        questionToRemove.remove();
    }
</script>

@endsection
