@extends('layouts.app')

@section('content')

    <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}

        <div class="my-card">
            <div class="title">
                <h2>Weet je het zeker?</h2>
            </div>
            <div class="my-row">
                <p>Titel:</p>
                <p>{{ $announcement->title }}</p>
            </div>
            <div class="my-row">
                <p>Body:</p>
                <p>{{ $announcement->body }}</p>
            </div>
            <div class="my-row">
                <input type="submit" value="Verwijderen">
            </div>
        </div>
    </form>
@endsection