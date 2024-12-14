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
    @csrf
    <div class="exam-container">
        <div class="exam-header">
            <div class="exam-infos">
                <p class="exam-title">{{ $exam->subject->subject_name }} - {{ $exam->title }}</p>
                <p class="exam-info">Date: {{ $exam->date }}</p>
                <p class="exam-info">End Time: {{ $exam->end_time }}</p>
                <p class="exam-info">Type: {{ $exam->type }}</p>
            </div>
        </div>



       
        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <p class="qst-title">Questions:</p>

        @foreach($questions as $question)
            <div>
                <input type="hidden" name="questions[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                <p class="qst-txt">{{ $loop->iteration }}. {{ $question->txt_question }}</p>
                <ul>
                    @foreach($question->options as $option)
                        <li>
                            <input type="checkbox" id="option{{ $option->id }}" name="questions[{{ $question->id }}][options][]" value="{{ $option->id }}">
                            <label class="opt-txt" for="option{{ $option->id }}">{{ $option->txt_option }}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

</form>
</div>

@endsection