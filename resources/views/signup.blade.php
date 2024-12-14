@extends('header')

@section('content')


<style>
    .error-message {
        background-color: #f8d7da;
        /* Couleur de fond */
        color: #721c24;
        /* Couleur du texte */
        padding: 10px 15px;
        /* Espacement intérieur */
        border: 1px solid #f5c6cb;
        /* Bordure */
        border-radius: 4px;
        /* Coins arrondis */
        margin-bottom: 20px;
        /* Marge inférieure */
    }
</style>

<!-- Sign-Up Formulaire -->
<div class="signup-page">
    <div class="signup-title">
        Sign Up
    </div>
    <div class="signup-formulaire">

        @if ($errors->has('email'))
            <div class="error-message">
                {{ $errors->first('email') }}
            </div>
        @endif



        <form class="signup-form" id="forma" onsubmit="signup()">
            @csrf
            <div class="first-inputs">
                <input class="id-input" id="code" type="text" placeholder="ID" oninput="checkCode()">
                <input class="firstname-input" name="firstname" type="text" placeholder="First Name">
            </div>
            <div class="second-inputs">
                <input class="lastname-input" name="lastname" type="text" placeholder="Last Name">
                <input class="email-input" name="email" type="email" placeholder="Email">
            </div>
            <div class="third-inputs">
                <input class="password-input" name="password" type="password" placeholder="Password">
                <input class="password-confirm-input" name="password_confirmation" type="password"
                    placeholder="Confirm Password">
            </div>
            <div id="filiere-input" style="display:none;">
                <select class="select-input" name="sector_id">
                    <option selected>Select your sector</option>
                    @foreach ($sectors as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->sector_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="signup-page-button">Sign Up</button>
            <div class="signup-message">Already have an account? <a class="signup-message-login"
                    href="{{ route('login') }}">Log In</a>
            </div>
        </form>

    </div>
</div>
<script>
    document.title = 'Sign Up';
    var form = document.getElementById('forma');
    var codeInput = document.getElementById('code');


    function signup() {
        var code = codeInput.value;
        if (code.match(/^[a-zA-Z]{1}\d{9}$/) || code.match(/^[a-zA-Z]{2}\d{8}$/)) {
            form.setAttribute("action", "{{ route('signup.s') }}");
            form.setAttribute("method", "POST");

            codeInput.setAttribute("name", "student_code");
        }
        else if (code.match(/^\d{10}$/)) {
            form.setAttribute("action", "{{ route('signup.t') }}");
            form.setAttribute("method", "POST");
            codeInput.setAttribute("name", "teacher_code");
        }
        else {
            alert('Enter valid code');
            form.setAttribute("action", "{{ route('signup') }}");
        }
    }



    function checkCode() {
        var code = codeInput.value;
        var filiereInput = document.getElementById('filiere-input');
        if (code.match(/^[a-zA-Z]{1}\d{9}$/) || code.match(/^[a-zA-Z]{2}\d{8}$/)) {
            filiereInput.style.display = "block"; // Affiche le champ de la filière
        } else {
            filiereInput.style.display = "none"; // Cache le champ de la filière
        }
    }
</script>

@endsection
