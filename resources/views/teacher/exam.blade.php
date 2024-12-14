@extends('header')

@section('content')

<style>
    body{
        margin-top: 60px;
    }
</style>
<!-- Sign-Up Formulaire -->
<div class="signup-page">
  <div class="signup-title-center">
    Enter your new Exam Informations
  </div>
  <div class="signup-formulaire">



    <form class="signup-form" id="forma" method="POST" action="{{ route('exam') }}">
      @csrf

      <div class="first-inputs">
        <input class="firstname-input" name="title" type="text" placeholder="Enter the Exam's Subject">
        <input class="firstname-input" name="start_time" type="time" placeholder="Enter the Exam's Start-Time">
      </div>
      <div class="second-inputs">
        <input class="lastname-input" name="date" type="date" lang="en" intl="en-US">
        <input class="firstname-input" name="end_time" type="time" placeholder="Enter the Exam's End-Time">
      </div>
      <div class="third-inputs">
        <select class="select-input" name="type">
          <option value="1">Canadien System</option>
          <option value="2">Normal System</option>
          <option value="3">Multiple Answers</option>
        </select>

        <select class="select-input" name="barem_choix" id="barem" oninput="checkBarem()">
          <option value="1">Free Scale</option>
          <option value="2">Fixed Scale</option>
        </select>
      </div>
      <div class="fourth-inputs">

        <select class="select-input" id="matiere" name="subject_name">
          @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
          @endforeach
        </select>
        <input class="firstname-input" name="score" id="score" type="number" placeholder="Exam's scale" style="display:none;">

      </div>
      <div>
        <input class="submit-input" name="submition" id="submit" type="submit" value="Validate">
      </div>
    </form>


  </div>
</div>




<script>
  document.title = 'Exam Infos';

  function copyCode() {
    const codeInput = document.getElementById('codeInput');
    codeInput.select();
    codeInput.setSelectionRange(0, 99999); // For mobile devices
    document.execCommand('copy');
    codeInput.setSelectionRange(0, 0);
    alert('Code copied to clipboard: ' + codeInput.value);

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
