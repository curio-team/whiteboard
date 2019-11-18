@extends('layouts.app')

@section('content')
    <div class="my-card">
        <div class="title">
            <h2>Admin</h2>
        </div>
        <p><a href="/">&lt; back</a></p>
        <ul>
            <li><a href="{{ route('announcements.index') }}">Announcements</a></li>
            <li><a href="{{ route('categories.index') }}">Categories</a></li>
            <li><a href="{{ route('count.index') }}">Aantallen vragen</a></li>
        </ul>
    </div>
@endsection