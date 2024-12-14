@extends('header')

@section('content')
<style>
    .exam-container {
        text-align: left;
        padding: 40px 70px;
    }

    .exam-title {
        font-family: Raleway;
        font-size: 26px;
        font-weight: bold;
        color: #EBA573;
        margin: 20px 0;
    }

    .exam-info {
        font-family: Poppins;
        color: #EBA573;
        font-size: 20px;
    }

    .qst-title {
        font-family: Raleway;
        font-size: 20px;
        font-weight: bold;
        color: #070F29;
    }

    .qst-txt {
        font-family: Poppins;
        font-size: 16px;
        color: #070F29;
        font-weight: 600;
    }

    ul {
        list-style-type: none;
        padding-left: 0;
    }

    .opt-txt {
        font-family: Raleway;
        font-size: 14px;
        color: #070F29;
        font-weight: 550;
    }

    .exam-header {
        display: flex;
        justify-content: space-between;
    }

    .btn {
        margin: 20px 10px 0 0;
        border: 1px solid #070F29;
        background-color: transparent;
        font-family: Raleway;
        font-size: 14px;
        padding: 10px 30px;
        color: #070F29;
        border-radius: 20px;
        transition: all 0.5s;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #070F29;
        color: white;
    }
</style>
<form id="examForm" action="{{ route('saveExamResponses') }}" method="POST">
    <div class="exam-container">
        <div class="exam-header">
            <div class="exam-infos">
                <p class="exam-title">{{ $exam->subject->subject_name }} - {{ $exam->title }}</p>
                <p class="exam-info">Date: {{ $exam->date }}</p>
                <p class="exam-info">End Time: {{ $exam->end_time }}</p>
                <p class="exam-info">Type: {{ $exam->type }}</p>
            </div>
            <div class="exam-sub">
                <button class="btn" type="submit">Finish</button>
            </div>
        </div>



        @csrf
        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <p class="qst-title">Questions:</p>

        @foreach($questions as $index => $question)
            <div>
                <input type="hidden" name="questions[{{ $index }}][question_id]" value="{{ $question->id }}">
                <p class="qst-txt">{{ $loop->iteration }}. {{ $question->txt_question }}</p>
                <ul>
                    @foreach($question->options as $option)
                        <li>
                            <input type="checkbox" name="questions[{{ $index }}][options][]" value="{{ $option->id }}">
                            <label class="opt-txt">{{ $option->txt_option }}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach


</form>

<script>
    document.title = 'Exam';
    // Convert PHP datetime to JavaScript Date object
    const examEndTime = new Date("{{ $examEndTime }}");

    function checkTime() {
        const currentTime = new Date();

        if (currentTime >= examEndTime) {
            alert('L\'examen est terminé. Vos réponses seront automatiquement enregistrées.');
            document.getElementById('examForm').submit();
        }
    }


    setInterval(checkTime, 5000);


    checkTime();

    // changement de fenetre
    let formSubmitted = false;
    document.getElementById('examForm').addEventListener('submit', function () {
        formSubmitted = true;
    });
    document.addEventListener('visibilitychange', function () {
        if (formSubmitted) return;

        const currentTime = new Date();
        if (currentTime <= examEndTime) {
            if (document.hidden) {
                window.location.href = "{{ route('showExams', ['subject_id' => $exam->subject_id]) }}";
            }
        }
    });


    // Désactiver copier-coller et clic droit
    document.addEventListener('copy', function (e) {
        e.preventDefault();
        alert('Copier n\'est pas autorisé sur cette page.');
    });

    document.addEventListener('cut', function (e) {
        e.preventDefault();
        alert('Couper n\'est pas autorisé sur cette page.');
    });

    document.addEventListener('paste', function (e) {
        e.preventDefault();
        alert('Coller n\'est pas autorisé sur cette page.');
    });

    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        alert('Clic droit n\'est pas autorisé sur cette page.');
    });

</script>

<script language='javascript' type='text/javascript'>
    function DisableBackButton() {
        window.history.forward()
    }
    DisableBackButton();
    window.onload = DisableBackButton;
    window.onpageshow = function (evt) { if (evt.persisted) DisableBackButton() }
    window.onunload = function () { void (0) }
</script>
@endsection
