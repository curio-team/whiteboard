@extends('layouts.app')

@section('content')

    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}

        <div class="my-card">
            <div class="title">
                <h2>Weet je het zeker?</h2>
            </div>
            <div class="my-row">
                <p>Naam:</p>
                <p>{{ $category->name }}</p>
            </div>
            <div class="my-row">
                <input type="submit" value="Verwijderen">
            </div>
        </div>
    </form>
@endsection