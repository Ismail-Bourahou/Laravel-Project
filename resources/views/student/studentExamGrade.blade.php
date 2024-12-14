@extends('header')

@section('content')

<style>
    h1{
        position: relative;
        margin-top: 24%;
        font-family: Poppins;
    }
</style>

    @forelse ($passedExams as $passed)
    <h1>Your score is : {{$passed->score}} / {{$passed->grade}}</h1>
    @empty
    <h1>Your teacher has not approved displaying grades yet</h1>
    @endforelse

@endsection
