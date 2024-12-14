@extends('header')

@section('content')

<link rel="stylesheet" href="{{asset('css/admin/home.css')}}">

<div class="container">
    <div class="links-container">
        <a class="link-button" href="{{ route('admin.home') }}">Users</a>
        <a class="link-button" href="{{ route('admin.subjects') }}">Subjects</a>
        <a class="link-button" href="{{ route('admin.sectors') }}">Sectors</a>
    </div>

    <div class="card-container">


        <!-- Pending Users Card -->
        <div class="card" onmousemove="adjustOpacity(event)" onmouseleave="resetOpacity(event)">
            <div class="highlight"></div>
            <div class="card-header">Pending Users</div>
            <div class="card-body">
                <p class="card-title">{{ $pendingUsersCount }}</p>
                <p class="card-text">Users awaiting approval.</p>
                <a href="{{ route('admin.pending-users') }}" class="btn btn-light">View Pending Users</a>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="card" onmousemove="adjustOpacity(event)" onmouseleave="resetOpacity(event)">
            <div class="highlight"></div>
            <div class="card-header">Teachers</div>
            <div class="card-body">
                <p class="card-title">{{ $teachersCount }}</p>
                <p class="card-text">Registered teachers.</p>
                <a href="{{ route('admin.showTeachers') }}" class="btn btn-light">View Teachers</a>
            </div>
        </div>

        <!-- Students Card -->
        <div class="card" onmousemove="adjustOpacity(event)" onmouseleave="resetOpacity(event)">
            <div class="highlight"></div>
            <div class="card-header">Students</div>
            <div class="card-body">
                <p class="card-title">{{ $studentsCount }}</p>
                <p class="card-text">Registered students.</p>
                <a href="{{ route('admin.showStudents') }}" class="btn btn-light">View Students</a>
            </div>
        </div>
    </div>
</div>
<a class="create" href="{{ route('admin.add-form') }}">+</a>

<script src="{{ asset('js/admin/home.js') }}"></script>

@endsection
