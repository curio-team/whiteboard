@extends('layouts.app')

@section('content')

    <div class="my-card">
        <div class="title">
            <h2>Categories</h2>
        </div>
        <div class="my-row">
            <p><a href="{{ route('admin.home') }}">&lt; back</a> | <a href="{{ route('categories.create') }}">new</a></p>
        </div>
        @foreach($categories as $category)
            <div class="my-row">
                <p>{{ $category->name }}</p>
                <p>
                    <a href="{{ route('categories.toggle', $category->id) }}">
                        <?php echo $category->published ? 'uitschakelen' : 'inschakelen'; ?>
                    </a>
                    |
                    <a href="{{ route('categories.edit', $category->id) }}">bewerken</a>
                </p>
            </div>
        @endforeach
    </div>
@endsection