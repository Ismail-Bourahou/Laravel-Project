@extends('header')

@section('content')

<link rel="stylesheet" href="{{asset('css/admin/pending.css')}}">

<div class="container">
    <h1 class="page-title">Pending Users</h1>
    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif
    <table align="center" class="tabl">
        <thead>
            <tr class="table-line">
                <th class="column-name">Name</th>
                <th class="column-name">Email</th>
                <th class="column-name">Role</th>
                <th class="column-name">Sector</th>
                <th class="column-name">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendingUsers as $user)
                <tr class="table-line">
                    <td class="column-text">{{ $user->firstname }} {{ $user->lastname }}</td>
                    <td class="column-text">{{ $user->email }}</td>
                    <td class="column-text">{{ $user->role }}</td>
                    <td class="column-text">@if($user->role == 'Student')
                        {{ $user->sector->sector_name }}
                    @else
                        Null
                    @endif</td>
                        <td class="column-text">
                            <form action="{{ route('admin.approve-user', $user->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn1">Approve</button>
                            </form>
                            <form action="{{ route('admin.decline-user', $user->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn2">Decline</button>
                            </form>
                        </td>
                </tr>
            @empty
                <tr class="table-line">
                    <td class="column-text" colspan="5">Empty</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
