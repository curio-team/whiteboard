@extends('layouts.app')

@section('content')

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="my-card">
            <div class="title">
                <h2>{{ $category->name }}</h2>
            </div>
            <div class="my-row">
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}">
            </div>
            <div class="my-row">
                <label for="published">Published:</label>
                <select id="published" name="published">
                    <option value="1" <?php echo $category->published ? 'selected="selected"' : ''; ?>>Ja</option>
                    <option value="0" <?php echo $category->published ? '' : 'selected="selected"'; ?>>Nee</option>
                </select>
            </div>
            <div class="my-row">
                <input type="submit" value="Opslaan">
                <p><a href="{{ route('categories.delete', $category->id) }}">delete</a></p>
                <p><a href="/admin/categories">&lt; back</a></p>
            </div>
        </div>
    </form>
@endsection