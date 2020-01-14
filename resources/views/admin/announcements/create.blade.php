@extends('layouts.app')

@section('content')

    <form action="{{ route('announcements.store') }}" method="POST">
        {{ csrf_field() }}

        <div class="my-card">
            <div class="title">
                <h2>New announcement</h2>
            </div>
            <div class="my-row">
                <label for="title">Titel:</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}">
            </div>
            <div class="my-row">
                <label for="body">Body (nullable, html allowed):</label>
                <textarea name="body" id="body" cols="90" rows="5">{{ old('body') }}</textarea>
            </div>
            <div class="my-row">
                <input type="submit" value="Opslaan">
                <p><a href="/admin/announcements">&lt; back</a></p>
            </div>
        </div>
    </form>
@endsection