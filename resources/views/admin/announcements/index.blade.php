@extends('layouts.app')

@section('content')

    <div class="my-card">
        <div class="title">
            <h2>Announcements</h2>
        </div>
        <div class="my-row">
            <p><a href="{{ route('admin.home') }}">&lt; back</a> | <a href="{{ route('announcements.create') }}">new</a></p>
        </div>
        @foreach($announcements as $announcement)
            <div class="my-row">
                <p>{{ $announcement->title }}</p>
                <p>
                    <a href="{{ route('announcements.edit', $announcement->id) }}">bewerken</a>
                </p>
            </div>
        @endforeach
    </div>
@endsection