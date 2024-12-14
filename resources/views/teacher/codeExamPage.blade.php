@extends('header')

@section('content')

<div class="signup-page">
    <div class="signup-title-center">
        Your exam's code :
    </div>
    <div class="signup-formulaire">



        <form class="signup-form" id="forma" method="POST" action="{{ route('code.create') }}">
            @csrf
          <div>
            <input style="background-color: transparent;border: 1px solid #DE6E1E;color:#DE6E1E;" class="submit-input" name="code" id="code" type="text" value="{{ $exam->code_exam }}" readonly>
            <img src="{{ asset('pngwing.com (6).png') }}" class="img-copy" onclick="copyCode()">
          </div>
          <input class="submit-input" name="submition" id="submit" type="submit" value="Validate">
        </form>


    </div>
</div>


<script>
  function copyCode() {
    /* Get the text field */
    var copyText = document.getElementById("code");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    alert("Code copié : " + copyText.value);
}

</script>

@endsection
