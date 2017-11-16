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
	<div class="container">
		<header>
		    <h1>Whiteboards</h1>
		    @if(Auth::check())
			    <div class="user">
			    	{{ Auth::user()->name }} (
			    		@if(Auth::user()->type == 'teacher')
			    			<a href="/admin">admin</a>&nbsp;|&nbsp;
			    		@endif
			    		<a href="https://login.amo.rocks/logout">uitloggen</a>
			    	)
			    </div>
		    @endif
		</header>
		<div class="main">
			@yield('content')
		</div>
		<footer>
			<p>This is an open-source project. Checkout our <a target="_blank" href="https://github.com/Radiuscollege/whiteboard/">GitHub</a> if you wish to contribute.</p><p>Please report any bugs or <a target="_blank" href="https://github.com/Radiuscollege/whiteboard/issues">issues</a> you find. Feel free to submit any ideas or improvements as well!</p>
		</footer>
	</div>

    @stack('scripts')
</body>
</html>