@extends('layouts.app')

@section('content')

    <form action="{{ route('categories.store') }}" method="POST">
        {{ csrf_field() }}

        <div class="my-card">
            <div class="title">
                <h2>New category</h2>
            </div>
            <div class="my-row">
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
            </div>
            <div class="my-row">
                <label for="published">Published:</label>
                <select id="published" name="published">
                    <option value="1" selected="selected">Ja</option>
                    <option value="0">Nee</option>
                </select>
            </div>
            <div class="my-row">
                <input type="submit" value="Opslaan">
                <p><a href="/admin/categories">&lt; back</a></p>
            </div>
        </div>
    </form>
@endsection