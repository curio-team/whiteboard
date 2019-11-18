@extends('layouts.app')

@section('content')

    <div class="my-card">
        <div class="title">
            <h2>
                Aantallen vragen<br />
                <small>Vanaf 18 november 2019</small>
            </h2>
        </div>
        <div class="my-row">
            
        </div>
        <div class="my-row">
            <a href="{{ route('admin.home') }}">&lt; back</a>
            <form class="form form-inline" action="{{ route('count.filter') }}" method="POST">
                {{ csrf_field() }}
                
                <select class="form-control" name="groups[]" multiple>
                    @foreach($groups as $group)
                        @if(substr($group['name'], 0, 4) == 'RIO4')
                            <option value="{{ $group['id'] }}" @if($group['selected']) selected @endif>{{ $group['name'] }}</option>
                        @endif
                    @endforeach
                </select>
                <button class="form-control">Filter klassen</button>
            </form>
        </div>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Aangemaakt</th>
                <th>Aantal</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->pushes }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection