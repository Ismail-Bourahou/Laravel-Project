<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Home Page</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.8/countUp.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <style>
        /* Header Style */
        body {
            /* Styles for the body */
            margin-top: 90px;
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }

        .alert {
            font-family: Raleway;
        }

        .header {
            /* Styles for the header */
            background-color: #070F29;
            padding: 0 70px;
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            /* Make the header fixed */
            top: 0;
            /* Position it at the top */
            width: 90.9%;
            /* Ensure it spans the full width */
            z-index: 1000;
            /* Ensure it appears above other content */
            left: 0;
        }

        .header-elements {
            /* Styles for the header elements */
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo {
            /* Styles for the header logo */
        }

        .logo {
            /* Styles for the logo */
            color: white;
            font-family: Poppins;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .header-sources {
            /* Styles for the header sources */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .home-source {
            /* Styles for the home source */
            padding: 10px;
            color: white;
            cursor: pointer;
            margin-right: 10px;
            font-family: Poppins;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.5s;
        }

        .home-source:hover {
            color: #DE6E1E;
        }

        .login-button {
            /* Styles for the login button */
            border: 1px solid white;
            color: white;
            padding: 10px;
            margin-right: 10px;
            margin-left: 10px;
        }

        .signup-button {
            /* Styles for the signup button */
            border: 1px solid black;
            background-color: #DE6E1E;
            color: black;
            padding: 10px;
            margin-left: 10px;
        }

        .login-button,
        .signup-button {
            border-radius: 35px;
            cursor: pointer;
            height: 16px;
            width: 100px;
            text-align: center;
            font-family: Raleway;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.5s;
            text-decoration: none;
        }

        .login-button:hover {
            background-color: white;
            color: #070F29;
        }

        .signup-button:hover {
            opacity: 0.9;
        }


        /* Body Style */

        .home-container {
            margin: 0 70px;
        }

        .status-message {
            font-family: Raleway;
            color: #DE6E1E;
        }

        .home-interface {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .home-title,
        .home-button {
            margin-bottom: 20px;
        }

        .home-title {
            font-family: Raleway;
            font-size: 40px;
            font-weight: bolder;
            color: #DE6E1E;
            width: 500px;
        }

        .home-button {
            display: flex;
            font-family: Raleway;
            background-color: #070F29;
            color: white;
            width: 100px;
            height: 16px;
            text-align: center;
            margin: 0 auto;
            justify-content: center;
            align-items: center;
            border-radius: 35px;
            padding: 10px;
            cursor: pointer;
            text-decoration: none;
        }

        /* New CSS for the dropdown menu */
        .dropdown {
            position: relative;
            display: inline-block;
            margin-left: 30px;
            margin-right: 30px;
        }

        .approve-new-btn {
            font-weight: 500;
            padding: 5px 10px;
            font-family: Poppins;
            border: 2px solid #070F29;
            border-radius: 15px;
            background-color: transparent;
            color: #070F29;
            cursor: pointer;
            transition: all 0.3s;
        }

        .approve-new-btn:hover {
            background-color: #070F29;
            color: white;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 150px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            left: -50px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropbtn {
            font-size: 24px;
            color: white;
            cursor: pointer;
            width: 25px;
        }

        /* Sign Up styles */

        .signup-page {
            /* Styles for the signup page */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: max-content;
        }

        .signup-title {
            /* Styles for the signup title */
            text-align: left;
            font-family: Raleway;
            font-size: 23px;
            font-weight: 600;
            margin: 10px 0 20px 0;
        }

        .signup-title-center {
            /* Styles for the signup title */
            text-align: center;
            font-family: Raleway;
            font-size: 23px;
            font-weight: 600;
            margin: 10px 0 30px 0;
        }

        .signup-formulaire {
            /* Styles for the signup form */
            margin-top: 20px;
        }

        .signup-form {
            /* Styles for the signup form */
        }

        .first-inputs {
            /* Styles for the first group of inputs */
            display: flex;

        }

        .id-input {
            /* Styles for the ID input */
        }

        .firstname-input {
            /* Styles for the first name input */
        }

        .second-inputs {
            /* Styles for the second group of inputs */
            display: flex;

        }

        .lastname-input {
            /* Styles for the last name input */
        }

        .email-input {
            /* Styles for the email input */
        }

        .third-inputs {
            /* Styles for the third group of inputs */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .password-input {
            /* Styles for the password input */
        }

        .password-confirm-input {
            /* Styles for the password confirmation input */
        }

        .id-input,
        .firstname-input,
        .lastname-input,
        .email-input,
        .password-input,
        .password-confirm-input,
        .submit-input,
        .select-div,
        .text-copy,
        .select-input,
        .score-input {
            width: 20rem;
            height: 50px;
            border-radius: 25px;
            border: 1px solid #DE6E1E;
            margin: 20px 5px 20px 5px;
            padding: 0 10px 0 30px;
            font-family: Poppins;
            color: #454444;
            transition: all 0.5s;
        }

        .select-div {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .select-input {
            flex: 1;
        }

        .filiere-input {
            width: 20rem;
            height: 50px;
            border-radius: 25px;
            border: none;
            font-family: Poppins;
            color: #454444;
            transition: all 0.5s;
        }

        .filiere-input:focus {}

        select,
        select:focus {}

        .submit-input {
            color: white;
            background-color: #DE6E1E;
            font-size: 15px;
            height: 51px;
            width: 22.6rem;
            text-align: center;
            cursor: pointer;
            padding: 0 10px 0 10px;
            border: none;
        }

        .id-input:focus,
        .firstname-input:focus,
        .lastname-input:focus,
        .email-input:focus,
        .select-div:focus,
        .password-input:focus,
        .password-confirm-input:focus,
        .text-copy:focus,
        .score-input:focus,
        .select-input:focus {
            border-color: #DE6E1E;
            outline: none;
            box-shadow: 1px 1px 10px #DE6E1E;
        }

        .success-message {
            font-family: Raleway;
            background-color: #DE6E1E;
            color: #070F29;
            margin: 0;
        }

        .text-copy {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .score-input {}

        .img-copy {
            width: 15px;
            cursor: pointer;
        }

        .exam-type-input,
        .exam-type-input:focus {
            border: none;
            outline: none;
            font-family: Poppins;
            color: #454444;
        }

        .label-1 {
            font-family: Raleway;

        }

        input::placeholder {
            color: #96969C;
            font-family: Raleway;
        }

        .fourth-inputs {
            /* Styles for the fourth group of inputs */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .signup-page-button {
            /* Styles for the signup button */
            border-radius: 35px;
            cursor: pointer;
            height: 42px;
            width: 250px;
            text-align: center;
            font-family: Raleway;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.5s;
            text-decoration: none;
            margin: 0 auto;
            margin-top: 20px;
            padding: 10px;
            background-color: #DE6E1E;
            border: none;
            color: white;
        }

        .signup-message {
            /* Styles for the signup message */
            font-family: Raleway;
            font-size: 15px;
            margin-top: 10px;
        }

        .signup-message-login {
            /* Styles for the signup message */
            font-weight: 700;
            color: #070F29;
            text-decoration: none;
        }

        .home-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 91.4vh;
        }

        .home-interface {
            text-align: center;
        }

        .home-title,
        .home-button {
            margin-bottom: 20px;
        }

        .home-title {
            font-family: Raleway;
            font-size: 40px;
            font-weight: bolder;
            color: #DE6E1E;
            width: 500px;
        }

        .home-button {
            display: flex;
            font-family: Raleway;
            background-color: #070F29;
            color: white;
            width: 100px;
            height: 16px;
            text-align: center;
            margin: 0 auto;
            justify-content: center;
            align-items: center;
            border-radius: 35px;
            padding: 10px;
            cursor: pointer;
            text-decoration: none;
        }

        /* ****************** Questions Style ******************* */

        /* Form container */
        .qst-container {
            /* Add your styles here */
            padding: 40px 70px 40px 70px;
        }

        /* Header section */
        .qst-head {
            /* Add your styles here */
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* Title */
        .qst-title {
            /* Add your styles here */
            font-family: Raleway;
            font-size: 26px;
            font-weight: 600;
        }

        /* Header buttons */
        .qst-head-btn {
            /* Add your styles here */

        }

        /* Back button */
        .back-btn,
        .save-btn {
            /* Add your styles here */
            font-family: Raleway;
            font-size: 18px;
            font-weight: normal;
            background-color: transparent;
            border-radius: 35px;
            width: 110px;
            height: 40px;
            cursor: pointer;
            transition: 0.5s all;
        }

        .back-btn:hover {
            background-color: #DE6E1E;
            color: white;
        }

        .save-btn:hover {
            background-color: #070F29;
            color: white;
        }

        .back-btn {
            color: #DE6E1E;
            border: 1px solid #DE6E1E;
        }

        /* Save button */
        .save-btn {
            /* Add your styles here */
            color: #070F29;
            border: 1px solid #070F29;
        }

        /* Form section */
        .qst-form {
            /* Add your styles here */
            display: block;
            margin: 30px 0 30px 0;
        }

        /* Input container */
        .qst-inputs {
            /* Add your styles here */
            width: 70%;
            display: flex;
            margin: 30px 0 30px 0;
        }

        /* Question input */
        .qst-input {
            /* Add your styles here */
            width: 810px;
            height: 40px;
            border: 1px solid #DE6E1E;
            border-radius: 29px;
            padding: 5px 10px 5px 30px;
            font-family: Raleway;
            color: black;
            transition: 0.5s all;
        }

        .qst-input:focus {
            /* Add your styles here */
            border-color: #DE6E1E;
            outline: none;
            box-shadow: 1px 1px 10px #DE6E1E;
        }

        /* Save button for question */
        #qst-save-btn {
            height: 50px;
            color: #DE6E1E;
            border-color: #DE6E1E;
            margin-left: 15px;
        }

        #qst-save-btn:hover {
            color: white;
            background-color: #DE6E1E;
        }

        /* Options section */
        .qst-opt {
            /* Add your styles here */
            width: 70%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Option input */
        #opt-input {
            /* Add your styles here */
            width: 350px;
        }

        /* Option checkbox and label container */
        .opt-check-choice {
            /* Add your styles here */

        }

        /* Option checkbox */
        .opt-choice {
            /* Add your styles here */
        }

        /* Option label */
        .opt-choice-label {
            /* Add your styles here */
            font-family: Poppins;
        }

        /* Add option button */
        .opt-add-btn {
            /* Add your styles here */
        }

        /* Bottom section */
        .qst-bttm {
            /* Add your styles here */
            position: fixed;
            left: 75.66%;
            top: 90%;
        }

        /* Add option button */
        #add-option {
            /* Add your styles here */
            width: 150px;
        }

        /* Add question button */
        #add-question {
            /* Add your styles here */
            width: 150px;
        }

        /* ***************** Teacher Interface Style ********************* */

        .exams-container {
            padding: 80px 100px 80px 100px;
            text-align: left;
        }

        .exam-ticket {
            background-color: #070F29;
            width: max-content;
            padding: 20px 50px 20px 30px;
            border-radius: 21px;
        }

        .exam-number {
            font-family: Poppins;
            color: white;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .exam-info {
            margin: 12px 0 12px 0;
        }

        .info {
            font-family: Raleway;
            color: white;
            font-size: 14px;
            font-weight: 400;
        }

        .exam-buttons {}

        .exam-btn {
            border-radius: 35px;
            width: 90px;
            height: 40px;
            border: none;
            font-family: Raleway;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.5s;
        }

        #publish {
            background-color: #DE6E1E;
            color: white;
        }

        #publish:hover {
            font-size: 16.5px;
        }

        #modify {
            background-color: transparent;
            color: white;
            border: 1px solid #DE6E1E;
        }

        #modify:hover {
            font-size: 16.5px;
        }
    </style>
</head>

<body>

    @php
        $teacher = \App\Models\Teacher::where('teacher_code', session('user_id'))->first();

        $student = \App\Models\Student::where('student_code', session('user_id'))->first();

        $admin = \App\Models\Admin::where('admin_code', session('user_id'))->first();

    @endphp

    <!-- Header -->
    <div class="header">
        <div class="header-elements">
            <div class="header-logo">
                @if(session()->has('user_id'))
                    @if($teacher)
                        <a class="logo" href="{{ route('teacher') }}">SmartExam</a>
                    @elseif($student)
                        <a class="logo" href="{{ route('student') }}">SmartExam</a>
                    @elseif($admin)
                        <a class="logo" href="{{ route('admin.home') }}">SmartExam</a>
                    @else
                        <!-- Afficher un lien de déconnexion si l'utilisateur est connecté mais ni un enseignant ni un étudiant -->
                    @endif
                @else
                    <a class="logo" href="{{ route('home') }}">SmartExam</a>
                @endif
            </div>
            <div class="header-sources">
                @if(session()->has('user_id'))
                    @if($teacher)
                        <a class="home-source" href="{{ route('teacher') }}">home</a>
                    @elseif($student)
                        <a class="home-source" href="{{ route('student') }}">home</a>
                    @elseif($admin)
                        <a class="home-source" href="{{ route('admin.home') }}">home</a>
                    @else
                        <!-- Afficher un lien de déconnexion si l'utilisateur est connecté mais ni un enseignant ni un étudiant -->
                    @endif
                    @if($teacher || $student)
                        <div class="dropdown">
                            <img src="{{asset('account.png')}}" alt="" class="dropbtn">
                            <div class="dropdown-content">
                                <a style="font-family: Raleway;" href="{{ route('account.show') }}">Account</a>
                                <a style="font-family: Raleway;" href="{{ route('logout') }}">Logout</a>
                            </div>
                        </div>


                    @else
                        <div class="dropdown">
                            <img src="{{asset('account.png')}}" alt="" class="dropbtn">
                            <div class="dropdown-content">
                                <a style="font-family: Raleway;" href="{{ route('logout') }}">Logout</a>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Afficher les boutons de connexion et d'inscription si l'utilisateur n'est pas connecté -->
                    <a href="{{ route('login') }}" class="login-button">Log In</a>
                    <a href="{{ route('signup') }}" class="signup-button">Sign Up</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Body -->
    @yield('content')

</body>


</html>
