@extends('header')

@section('content')

<!-- Sign-Up Formulaire -->
<div class="signup-page">
  <div class="signup-title-center">
    Validate your Exam Informations
  </div>
  <div class="signup-formulaire">

    @if ($errors->has('email'))
    <div class="alert alert-danger">
    {{ $errors->first('email') }}
    </div>
  @endif

    <form class="signup-form" id="forma" method="POST" action="{{ route('exam.update', ['exam' => $exam->id]) }}">
      @csrf

      <div class="first-inputs">
        <input class="firstname-input" name="title" type="text" value=" {{ $exam->title }}">
        <input class="firstname-input" name="start_time" type="time" id="start_time">
      </div>
      <div class="second-inputs">
        <input class="lastname-input" name="date" type="date" lang="en" intl="en-US" value="{{ $exam->date }}">
        <input class="firstname-input" name="end_time" type="time" id="end_time">
      </div>
      <div class="third-inputs">
        <select class="select-input" name="type">
          <option value="1" {{ $exam->type == 'Canadien System' ? 'selected' : '' }}>Canadien System</option>
          <option value="2" {{ $exam->type == 'Normal System' ? 'selected' : '' }}>Normal System</option>
          <option value="3" {{ $exam->type == 'Multiple Answers' ? 'selected' : '' }}>Multiple Answers</option>
        </select>

        <select class="select-input" name="barem_choix" id="barem" oninput="checkBarem()">
          <option value="1" {{ $exam->score_type == 'barem libre' ? 'selected' : '' }}>Free Scale </option>
          <option value="2" {{ $exam->score_type == 'barem fix' ? 'selected' : '' }}>Fixed Scale</option>
        </select>

      </div>
      <div class="fourth-inputs">

        <select class="select-input" id="matiere" name="subject_name">
          @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" {{ $exam->subject_id == $subject->id ? 'selected' : '' }}>
                  {{ $subject->subject_name }}
            </option>
          @endforeach
        </select>

        <input class="firstname-input" name="score" id="score" type="number" placeholder="Exam's scale"
          value="{{ $exam->score }}">

      </div>
      <div>
        <input class="submit-input" name="submition" type="submit" value="Validate">
      </div>
    </form>


  </div>
</div>


<script>
  document.title = 'Exam Infos';


  var start = document.getElementById('start_time');
  start.setAttribute("value", "{{ $exam->start_time }}");

  var end = document.getElementById('end_time');
  end.setAttribute("value", "{{ $exam->end_time }}");


  var barem = document.getElementById('barem');
  var score = document.getElementById('score');
  if (barem.value == 1) {
    score.style.display = 'none';
  }



  function checkBarem() {
    var barem = document.getElementById('barem');
    var score = document.getElementById('score');

    if (barem.value == 2) {
      score.style.display = 'inline';

    } else {
      score.style.display = 'none';
    }
  }


</script>

@endsection
