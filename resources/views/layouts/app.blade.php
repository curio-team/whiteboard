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
	<header>
	    <h1>Whiteboard</h1>
	    <div class="user">
	    	{{ Auth::user()->name }} (
	    		@if(Auth::user()->type == 'teacher')
	    			<a href="/admin">admin</a>&nbsp;|&nbsp;
	    		@endif
	    		<a href="https://login.amo.rocks/logout">uitloggen</a>
	    	)
	    </div>
	</header>
    @yield('content')
    @stack('scripts')
</body>
</html>