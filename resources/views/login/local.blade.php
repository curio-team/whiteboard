@extends('layouts.app')

@section('content')
    <form action="/login" method="POST">
        {{ csrf_field() }}
        ID: <input type="text" name="id" value="ab01">
        <input type="submit">
    </form>
@endsection