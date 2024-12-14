@extends('header')

@section('content')

<style>
    .container {
        text-align: center;
        padding: 0 70px;
    }

    .sdt-pss {
        font-family: Raleway, sans-serif;
        font-size: 22px;
        font-weight: 600;
        color: #070F29;
        text-align: center;
        margin-bottom: 20px;
    }

    ul {
        list-style-type: none;
        display: block;
        text-align: center;
        padding: 0;
    }

    li {
        text-align: left;
        margin: 0 20%;
        padding: 20px;
        font-family: Poppins;
        font-size: 18px;
        font-weight: 600;
        color: #070F29;
        border: 1px solid #070F29;
        display: flex;
        justify-content: space-between;
    }

    li:hover {
        background-color: #f0f0f0;
    }

    .sdt-name {
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    span {
        color: #DE6E1E;
    }

    .approve-btn {
        margin: 20px;
        padding: 10px 20px;
        font-size: 16px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .approve-btn:hover {
        background-color: #218838;
    }

    .status {
        margin-bottom: 20px;
        padding: 10px;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
    }

    .links-container {
        display: flex;
        justify-content: center; /* Centrer les boutons */
        gap: 80px; /* Espace entre les boutons */
        margin-top: 100px;
        margin-bottom: 50px; /* Espace en bas */
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
    <a class="link-button {{ request()->routeIs('exam.details') ? 'active' : '' }}" href="{{ route('exam.details', ['examId' => $exam_id]) }}">passed students</a>
    <a class="link-button {{ request()->routeIs('nonePassed') ? 'active' : '' }}" href="{{ route('nonePassed', ['exam_id' => $exam_id]) }}">none passed students</a>
</div>

<div class="container">

    @if (session('status'))
        <div class="status">
            {{ session('status') }}
        </div>
    @endif

    @if (!$isApproved)
        <form id="approveForm" action="{{ route('approveDisplayingGrades', ['exam_id' => $exam_id]) }}" method="POST">
            @csrf
            <button type="submit" class="approve-btn" id="approveBtn">Approve displaying results ?</button>
        </form>
    @endif

    <ul>
        @foreach($passedStudents as $student)
            <li class="name">
                <a class="sdt-name"
                    href="{{ route('exam.student.details', ['examId' => $student->exam_id, 'studentId' => $student->id]) }}">
                    <span>{{ $student->full_name }}</span><span>{{ $student->grade }} / {{ $student->score }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>

<script>
    document.title = 'Students List';

    document.getElementById('approveForm')?.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission to see the effect of the button text change
        const approveBtn = document.getElementById('approveBtn');
        approveBtn.textContent = 'Approved';
        approveBtn.disabled = true; // Optionally disable the button to prevent multiple clicks
        this.submit(); // Submit the form after changing the button text
    });
</script>

@endsection
