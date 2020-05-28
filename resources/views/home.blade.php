<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/home.css') }}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<title>Home Page</title>
</head>
<body>

	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="/home">DawgCinemas</a>
		</div>
		<ul class="nav navbar-nav">
		  <li class="active"><a href="/home"><span class="glyphicon glyphicon-home"></span></a></li>
		  <li><a href="/account"><span class="glyphicon glyphicon-user"> </span></a></li>
		  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Movies <span class="caret"></span></a>
			<ul class="dropdown-menu">
                @foreach($movies as $movie)
			  <li><a href="/movie/{{$movie->title}}">{{$movie->title}}</a></li>
                @endforeach
			</ul>
		  </li>
            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::User()->isAdmin == 1)
		  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Manage Tools<span class="caret"></span></a>
			<ul class="dropdown-menu">
                <li><a href="/nova/resources/users">Users</a></li>
                <li><a href="/nova/resources/movies">Movies</a></li>
                <li><a href="/nova/resources/showings">Show Times</a></li>
                <li><a href="/nova/resources/showrooms">Auditoriums</a></li>
                <li><a href="/nova/resources/promotions">Promotions</a></li>
                <li><a href="/nova">Statistics</a></li>
			</ul>
		  </li>
            @endif
            <li>
                <input style="margin:8%;" type="text" placeholder="Search.." id="searchBar" name="search">
            </li>
            <li>
                <button style="margin-top:43%;margin-left: 45%;" onClick="search()" type="submit"><i class="fa fa-search"></i></button>
                <script>
                    function search() {
                            let info = document.getElementById('searchBar').value
                        window.location.href = 'http://127.0.0.1:8000/my-search/?search=' + info;
                    }
                </script>
            </li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
            @if(\Illuminate\Support\Facades\Auth::check())
                <li><a href="/returnTickets"><span class="glyphicon glyphicon-shopping-cart"></span> Return Tickets</a></li>
                <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            @else
                <li><a href="/register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            @endif
        </ul>
	  </div>
	</nav>

	<div class="container-fluid" >
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"> </li>
			</ol>

			<div class="carousel-inner">
                @foreach($movies as $movie)
                    @if($movie->title == $movies[0]->title)
				<div class="item active">
                    @else
                        <div class="item">
                            @endif
                        <object style="width:100%; height: 500px;" data="{{$movie->videoLink}}"></object>
				</div>
                    @endforeach
			</div>

			<a class="left carousel-control" href="#myCarousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
	<div class="outerContainer">
        <h2 style="text-align: center"><i><u><b>Currently Playing</b></u></i></h2>
        @foreach($movies_now as $movie)
			<div class="cardContainer inline-link">
				<a href="/movie/{{$movie->title}}" ><img class="card" src="{{$movie->pictureLink}}" alt="{{$movie->title}}"/></a>
            </div>
        @endforeach
        <h2 style="text-align: center"><i><u><b>Coming Soon</b></u></i></h2>
        @if(sizeof($movies_soon) == 0)
            <h2>No New Titles. Check Back Soon for upcoming pictures</h2>
            @else
        @foreach($movies_soon as $movie)
            <div class="cardContainer inline-link">
                    <a href="/movie/{{$movie->title}}" ><img class="card" src="{{$movie->pictureLink}}" alt="{{$movie->title}}"/></a>
            </div>
        @endforeach
            @endif
		</div>
    </div>

</body>
</html>
