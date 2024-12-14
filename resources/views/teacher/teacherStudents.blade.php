@extends('header')

@section('content')

<style>

    .container {
        max-width: 70%;
        margin: 0 auto;
        padding: 20px;
    }

    .students {
        font-family: Raleway, sans-serif;
        font-size: 28px;
        font-weight: bold;
        color: #070F29;
        text-align: center;
        margin-bottom: 20px;
    }

    .student-card {
        border-radius: 18px;
        font-family: Raleway, sans-serif;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #070F29;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        gap: 50px;
    }

    .student-card:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .student-info {
        font-family: Raleway, sans-serif;
        font-size: 14px;
        margin-left: 100px;
    }

    .exams {
        font-family: Raleway, sans-serif;
        font-size: 28px;
        font-weight: bold;
        color: #070F29;
        text-align: center;
        margin-bottom: 20px;
    }

    .details-link {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 20px;
        background-color: #DE6E1E;
        color: #fff;
        text-decoration: none;
        border-radius: 15px;
        transition: background-color 0.3s ease;
        font-family: Raleway, sans-serif;
        width: fit-content;
        margin: 0 auto;
    }

    .links-container {
        display: flex;
        justify-content: center;
        gap: 80px;
        margin-bottom: 30px;
    }

    .link-button {
        position: relative;
        padding: 10px 20px;
        font-family: Raleway;
        font-size: 16px;
        font-weight: 600;
        color: #070F29;
        text-decoration: none;
        transition: color 0.3s;
    }

    .link-button::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 100%;
        height: 2px;
        background-color: #EBA573;
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.3s ease;
    }

    .link-button:hover::after,
    .link-button.active::after {
        transform: scaleX(1);
        transform-origin: left;
    }

    .link-button:hover {
        color: #EBA573;
    }


</style>


<div class="links-container">
    <a class="link-button" href="{{ route('teacher') }}">Exam List</a>
    <a class="link-button" href="{{ route('teacherStudents') }}">Students List</a>
</div>

<div class="container">
    @if($students->isEmpty())
        <p style="font-family: Raleway;">No students found for the subjects you teach.</p>
    @else
        @foreach($students as $student)
            <div class="student-card">
                <p class="student-info"><strong>Name:</strong>
                    {{ $student->firstname }}<span>&nbsp{{ $student->lastname }}</span></p>
                <p class="student-info"><strong>Sector:</strong> {{ $student->sector->sector_name }}</p>
                <!-- Ajoutez ici toute autre information pertinente sur l'étudiant -->
                <a class="details-link" href="{{ route('students.passedExams', ['student' => $student->id]) }}">View Passed
                    Exams</a>
            </div>
        @endforeach
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const currentLocation = window.location.href;
        const links = document.querySelectorAll('.link-button');

        links.forEach(link => {
            if (link.href === currentLocation) {
                link.classList.add('active');
            }
        });
    });
</script>

@endsection
