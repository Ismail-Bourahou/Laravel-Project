@extends('header')

@section('content')

<style>
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        font-family: Poppins, sans-serif;
    }

    .profile-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #777;
        margin-bottom: 20px;
        position: relative;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
    }

    .profile-image input[type="file"] {
        display: none;
    }

    .profile-image label {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: #070F29;
        color: white;
        padding: 0 3px 7px 3px;
        border-radius: 50%;
        cursor: pointer;
    }

    .profile-info {
        width: 100%;
    }

    .profile-info p {
        font-size: 18px;
        margin: 10px 0;
    }

    .profile-info .label {
        font-weight: bold;
    }

    span{
        font-family: Raleway;
    }

    .code{

    }

    .full{

    }

    .mail{

    }

    .sector{

    }

    .modify-btn{
        background-color: #DE6E1E;
        padding: 10px 20px;
        font-family: Raleway;
    }
</style>

<div class="container">
    <div class="profile-container">
        <div class="profile-image">
            @if($user->profileImage)
                <img src="{{ asset('storage/' . $user->profileImage->image_path) }}" alt="Profile Image">
            @else
                <span>?</span>
            @endif
            <input type="file" id="profile-image-input" onchange="uploadProfileImage()">
            <label for="profile-image-input">&#x1F4F7;</label>
        </div>



        <div class="profile-info">
            @if($type == 'student')
                <p class="code"><span class="label">Student Code:</span> {{ $user->student_code }}</p>
                <p class="full"><span class="label">Full Name:</span> {{ $user->firstname }} {{ $user->lastname }}</p>
                <p class="mail"><span class="label">Email:</span> {{ $user->email }}</p>
                <p class="sector"><span class="label">Sector:</span> {{ $user->sector->sector_name }}</p>
            @elseif($type == 'teacher')
                <p class="code"><span class="label">Teacher Code:</span> {{ $user->teacher_code }}</p>
                <p class="full"><span class="label">Full Name:</span> {{ $user->firstname }} {{ $user->lastname }}</p>
                <p class="mail"><span class="label">Email:</span> {{ $user->email }}</p>
            @endif
        </div>
    </div>
    <a class="modify-btn" href="{{route('change.password')}}">Modify your Password</a>
</div>

<script>
    function uploadProfileImage() {
        var input = document.getElementById('profile-image-input');
        var file = input.files[0];

        if (file) {
            var formData = new FormData();
            formData.append('profile_image', file);

            fetch('{{ route('profile.uploadImage') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to upload image');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>

@endsection
