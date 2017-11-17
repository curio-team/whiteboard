<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @if(Gate::allows('admin'))
    	<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  		<script>
  			Pusher.logToConsole = true;
		    var pusher = new Pusher('f80c5128c14ec84e1da9', {
		      	cluster: 'eu',
		      	encrypted: true
		    });

		    var channel = pusher.subscribe('whiteboard');
		    channel.bind('reload', function(data) {
		    	location.reload();
		    });
	  	</script>
    @endif

    <!-- (fav)icons -->
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- /end (fav)icons -->

    <title>Whiteboard</title>
</head>
<body>
	<div class="container">
		<header>
		    <h1><a href="{{ route('home') }}">Whiteboards</a></h1>
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