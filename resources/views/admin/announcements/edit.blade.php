@extends('layouts.app')

@section('content')

    <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="my-card">
            <div class="title">
                <h2>{{ $announcement->name }}</h2>
            </div>
            <div class="my-row">
                <label for="title">Titel:</label>
                <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}">
            </div>
            <div class="my-row">
                <label for="body">Body (nullable, html allowed):</label>
                <textarea name="body" id="body" cols="90" rows="5">{{ old('body', $announcement->body) }}</textarea>
            </div>
            <div class="my-row">
                <input type="submit" value="Opslaan">
                <a href="{{ route('announcements.delete', $announcement->id) }}">delete</a>
            </div>
        </div>
    </form>
@endsection