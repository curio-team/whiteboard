@extends('layouts.app')

@section('content')
    <div class="my-card">
        <div class="title">
            <h2>Admin</h2>
        </div>
        <p><a href="/">&lt; back</a></p>
        <ul>
            <li>Announcements</li>
            <li><a href="{{ route('categories.index') }}">Categories</a></li>
        </ul>
    </div>
@endsection