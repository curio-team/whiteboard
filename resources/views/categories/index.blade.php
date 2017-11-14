<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>Whiteboard</title>
</head>
<body>
    <h1>Whiteboard</h1>
    <div class="board">
        @foreach($categories as $category)
        <div class="category">
            <div class="title">
                <h2>{{$category->name}}</h2>
                <div>
                    <a class="btn btn-primary" onclick="addUserToCategory({{$category->id}})">Voeg mij toe</a>
                </div>
            </div>
            <ul>
                @foreach($category->users as $user)
                    <li>{{$user->name}} ({{$user->pivot->description}}) <a class="pull-right glyphicon glyphicon-remove" onclick="removeUserFromCategory({{$category->id}})"></a></li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    <script>
        function addUserToCategory(categoryId){
            var reason = prompt("Beschrijf kort je vraag:");

            var form = document.querySelector('#SignUpForm');
            var category_id = document.querySelector('#SignUpForm [name=category_id]');
            var description = document.querySelector('#SignUpForm [name=description]');

            category_id.value = categoryId;
            description.value = reason;

            form.submit();
        }

        function removeUserFromCategory(categoryId){
            var form = document.querySelector('#SignOffForm');
            var category_id = document.querySelector('#SignOffForm [name=category_id]');

            category_id.value = categoryId;

            form.submit();
        }
        @if(!empty($errors->already_on->first(0)))
            alert('{{$errors->already_on->first(0)}}');
        @endif
    </script>

    <form id="SignUpForm" action="{{ route('category.signup') }}" method="POST" style="display: none;">
        {{ csrf_field() }}

        <input type="hidden" name="category_id">
        <input type="hidden" name="description">
        <input type="submit" value="">
    </form>

    <form id="SignOffForm" action="{{ route('category.signoff') }}" method="POST" style="display: none;">
        {{ csrf_field() }}

        <input type="hidden" name="category_id">
        <input type="submit" value="">
    </form>
</body>
</html>