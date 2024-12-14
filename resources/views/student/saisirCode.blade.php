@extends('header')

@section('content')

<div class="signup-page">
    <div class="signup-title-center">
        Enter the exam's code :
    </div>
    <div class="signup-formulaire">

      @if (session('status'))
      <div class="alert alert-danger">
          {{ session('status') }}
      </div>
    @endif


        <form class="signup-form" id="forma" method="POST" action="{{ route('validate.exam.code') }}">
            @csrf
          <div>
            <input  name="exam_id" id="exam_id" type="hidden" value="{{ $exam_id }}" >
            <input class="firstname-input" name="code" id="code" type="text" >
          </div>
          <input class="submit-input" name="submition" id="submit" type="submit" value="Validate">
        </form>


    </div>
</div>

  @endsection
