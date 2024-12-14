@extends('header')

@section('content')

<link rel="stylesheet" href="{{asset('css/admin/add-user.css')}}">

<div class="add-cont" id="add1">
    <div class="add-choice">
        <div class="signup-title">
            Choose the User you want to add
        </div>
        <select class="select-input" id="user-type" name="type">
            <option value="0">Select User Type</option>
            <option value="1">Admin</option>
            <option value="2">Teacher</option>
            <option value="3">Student</option>
        </select>
    </div>
</div>

<div class="signup-page">
    <div class="signup-title" id="tit">
        Add User
    </div>
    <div class="signup-formulaire">

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="signup-form" id="forma" action="{{ route('admin.add-user') }}" method="POST">
            @csrf
            <input type="hidden" id="hidden-user-type" name="type" value="">
            <div class="first-inputs" id="first-ipt">
                <input class="id-input" id="code" name="code" type="text" placeholder="ID">
                <input class="firstname-input" id="firstname" name="firstname" type="text" placeholder="First Name" style="display:none;">
            </div>
            <div class="second-inputs" id="second-ipt">
                <input class="lastname-input" id="lastname" name="lastname" type="text" placeholder="Last Name" style="display:none;">
                <input class="email-input" id="email" name="email" type="email" placeholder="Email" style="display:none;">
            </div>
            <div class="third-inputs" id="third-ipt">
                <input class="password-input" id="password" name="password" type="password" placeholder="Password">
                <input class="password-confirm-input" id="password_confirmation" name="password_confirmation"
                    type="password" placeholder="Confirm Password">
            </div>
            <div id="filiere-input" style="display:none;">
                <select class="select-input" id="sector_id" name="sector_id">
                    <option selected>Select the sector</option>
                    @foreach ($sectors as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->sector_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="signup-page-button">Add</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/admin/add-user.js') }}"></script>

@endsection
