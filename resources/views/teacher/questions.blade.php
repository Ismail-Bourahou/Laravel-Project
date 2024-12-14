@extends('header')

@section('content')

<style>
    body{
        margin-top: 90px;
    }

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
    <h1 class="title">Add Questions for your Exam</h1>
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <div class="qst-head">
            <h2 class="qst-title">Questions</h2>
            <button class="finish" type="submit">Save & Exit</button>
        </div>

        <input type="hidden" id="examScore" name="examScore" value="{{ session('exam_score') }}">

        <div id="questions-container">
            <div class="question-container">
                <div class="exam-head">
                    <input placeholder="Question" class="qst-ipt" type="text" name="questions[0][txt_question]" required>
                    <div class="note">
                        <label class="score-label grade-label" for="grade">Score</label>
                        <input class="score-ipt grade-label" type="number" name="questions[0][grade]">
                    </div>
                    <div class="btns">
                        <button class="opt-btn" type="button" onclick="addOption(this)">Add Option</button>
                        <button class="dlt-btn" type="button" onclick="deleteQuestion(this)">Delete Question</button>
                    </div>
                </div>

                <div class="options-container">
                    <section class="opt-sec">
                        <input placeholder="Option" class="opt-ipt" type="text" name="questions[0][options][0][txt_option]" required>
                        <div class="opt-true">
                            <label class="opt-label" for="options">True</label>
                            <input class="opt-check" type="checkbox" name="questions[0][options][0][is_correct]" value="1">
                        </div>
                        <img class="opt-dlt" src="{{ asset('delet.png') }}" onclick="removeOption(this)">
                    </section>
                    <section class="opt-sec">
                        <input placeholder="Option" class="opt-ipt" type="text" name="questions[0][options][1][txt_option]" required>
                        <div class="opt-true">
                            <label class="opt-label" for="options">True</label>
                            <input class="opt-check" type="checkbox" name="questions[0][options][1][is_correct]" value="1">
                        </div>
                        <img class="opt-dlt" src="{{ asset('delet.png') }}" onclick="removeOption(this)">
                    </section>
                </div>
            </div>
        </div>

        <button class="add-qst" type="button" onclick="addQuestion()">Add Question</button>
    </form>
</div>

<script>
    let questionIndex = 0;

    document.addEventListener('DOMContentLoaded', (event) => {
        const examScoreInput = document.getElementById('examScore');
        const examScore = examScoreInput.value;

        localStorage.setItem('examScore', JSON.stringify(examScore));

        if (examScore) {
            hideGradeFields();
        }
    });

    function hideGradeFields() {
        const gradeLabels = document.querySelectorAll('.grade-label');
        gradeLabels.forEach(label => label.style.display = 'none');
    }

    function addQuestion() {
        questionIndex++;
        const questionsContainer = document.getElementById('questions-container');

        const questionContainer = document.createElement('div');
        questionContainer.classList.add('question-container');

        questionContainer.innerHTML = `
            <div class="exam-head">
                <input placeholder="Question" class="qst-ipt" type="text" name="questions[${questionIndex}][txt_question]" required>
                <div class="note">
                    <label class="score-label grade-label" for="grade">Score</label>
                    <input class="score-ipt grade-label" type="number" name="questions[${questionIndex}][grade]">
                </div>
                <div class="btns">
                    <button class="opt-btn" type="button" onclick="addOption(this)">Add Option</button>
                    <button class="dlt-btn" type="button" onclick="deleteQuestion(this)">Delete Question</button>
                </div>
            </div>

            <div class="options-container">
                <section class="opt-sec">
                    <input placeholder="Option" class="opt-ipt" type="text" name="questions[${questionIndex}][options][0][txt_option]" required>
                    <div class="opt-true">
                        <label class="opt-label" for="options">True</label>
                        <input class="opt-check" type="checkbox" name="questions[${questionIndex}][options][0][is_correct]" value="1">
                    </div>
                    <img class="opt-dlt" src="{{ asset('delet.png') }}" onclick="removeOption(this)">
                </section>
                <section class="opt-sec">
                    <input placeholder="Option" class="opt-ipt" type="text" name="questions[${questionIndex}][options][1][txt_option]" required>
                    <div class="opt-true">
                        <label class="opt-label" for="options">True</label>
                        <input class="opt-check" type="checkbox" name="questions[${questionIndex}][options][1][is_correct]" value="1">
                    </div>
                    <img class="opt-dlt" src="{{ asset('delet.png') }}" onclick="removeOption(this)">
                </section>
            </div>
        `;

        questionsContainer.appendChild(questionContainer);

        if (examScore) {
            hideGradeFields();
        }
    }

    function deleteQuestion(button) {
        const questionToRemove = button.closest('.question-container');
        questionToRemove.remove();
    }

    function addOption(button) {
        const questionContainer = button.closest('.question-container');
        const optionsContainer = questionContainer.querySelector('.options-container');
        const optionCount = optionsContainer.querySelectorAll('.opt-sec').length;
        const questionIndex = questionContainer.querySelector('.qst-ipt').name.match(/\d+/)[0];

        const newOption = document.createElement('section');
        newOption.classList.add('opt-sec');
        newOption.innerHTML = `
            <input placeholder="Option" class="opt-ipt" type="text" name="questions[${questionIndex}][options][${optionCount}][txt_option]" required>
            <div class="opt-true">
                <label class="opt-label" for="options">True</label>
                <input class="opt-check" type="checkbox" name="questions[${questionIndex}][options][${optionCount}][is_correct]" value="1">
            </div>
            <img class="opt-dlt" src="{{ asset('delet.png') }}" onclick="removeOption(this)">
        `;
        optionsContainer.appendChild(newOption);
    }

    function removeOption(button) {
        const optionToRemove = button.closest('.opt-sec');
        optionToRemove.remove();
    }
</script>

@endsection
