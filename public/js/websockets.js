var pusher = new Pusher('f80c5128c14ec84e1da9', {
  	cluster: 'eu',
  	encrypted: true
});

var channel = pusher.subscribe('whiteboard');

channel.bind('signup', function(data) {
	var category = document.getElementById("category-" + data.category);
	var li = document.createElement('li');
	li.id = "category-" + data.category + "-user-" + data.user.id;
	li.innerHTML = data.user.name;
	li.innerHTML += '<a class="pull-right glyphicon glyphicon-remove" href="/signoff/user/' + data.user.id + '/category/' + data.category + '"></a>';
	category.appendChild(li);
});

channel.bind('signoff', function(data) {
	var li = document.getElementById("category-" + data.category + "-user-" + data.user.id);
	li.parentNode.removeChild(li);
});