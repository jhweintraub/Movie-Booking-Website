<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/datepicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/movies.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/home.css') }}"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$(function(){
			$("#datepicker").datepicker();
		});
	</script>

	<title>Movie: {{$movie->title}}</title>
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
                @foreach ($movies as $movie_indiv)
			  <li><a href="/movie/{{$movie_indiv->title}}">{{$movie_indiv->title}}</a></li>
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
			<li><a href="/checkout"><span class="glyphicon glyphicon-shopping-cart"></span> Check Out</a></li>
			<li><a href="/register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			<li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		</ul>
	  </div>
	</nav>

	<div class="container container-fluid" >
		<div class="panel panel-default" >
			<div class="panel-heading"><h4>{{$movie->title}} | {{$movie->rating}}</h4></div>
			<div class="panel-body">
				<div>
					<object width="100%" height="400px" data="{{$movie->videoLink}}"></object>
				</div>
			</div>
			<div class="panel-footer">
                <i>{{$movie->synopsis}}</i><br>
                <i>Director: {{$movie->director}}</i><br>
                <i>Producer: {{$movie->producer}}</i><br>
                <i>Category: {{$movie->category}}</i><br>
                <i>Duration: {{$movie->duration}} Minutes</i><br>
                <i>Cast: </i>
                <ul>
                    @foreach($actors as $actor)
                        <li>{{$actor->name}}</li>
                        @endforeach
                </ul>
            </div>
		</div>
    </div>

    <div class="container container-fluid" >
        <div class="panel panel-default" >
            <div class="panel-heading"><h4>Reviews</h4></div>
            <div class="panel-body">
                <div>
                    <ul>
                        @if (sizeof($reviews) == 0)
                            No Reviews. Click Here to Be the First.
                        @else
{{--                            @for ($x = 0; $x < sizeof($reviews); $x++)--}}
                        @foreach ($reviews as $review)
                                <li><i>{{$review->review}}</i></li>
                            @endforeach
                        @endif
                    </ul>
                    <br>
                    <a style="margin-left: 1.85%" href="/new_review">Click Here to Add a New Review</a>
                </div>

            </div>

            </div>
        </div>
    </div>

		<div class="panel panel-default" style="">
			<div class="panel-heading" >
				<input style= "margin: 10 px; display: inline-block ! important;" type="text" placeholder="Date" id="datepicker">
				<input type="time" placeholder="--:--- --" min="09:00 AM" max="12:00 AM">
				<i>Select a date and starting time</i>
			</div>

			<div class="panel-body">
				<div class="container-fluid" id="audSlt">
						<div class="container-fluid"> <!--Dolby Surround Sound -->
						<h4>Showtimes. Click to Book Tickets (EST)</h4>
                            @if (sizeof($showTimes) == 0)
                                <p>No Showtimes Scheduled. Please check Back later</p>
                            @else
						@foreach ($showTimes as $showTime)
                                    <button class="btn btn-primary" onclick="window.location.href='/seats/{{$movie->id}}/{{$showTime->id}}'">{{$showTime->dateTime}}</button>
                        @endforeach
                        @endif
				</div>
            <br>
			</div>

			<div class="panel-footer">
			<input type="submit" class="btn btn-info" value="Update Order">
			<a href="checkout.html"><input type="submit" class="btn btn-info" value="Checkout"></a>
			</div>
		</div>
	</div>

	<div class = "outerContainer">
        <h2 style="text-align: center"><i><u><b>Other Titles</b></u></i></h2>
        @foreach($movies as $movie)
            <div class="cardContainer inline-link">
                @if($movie->is_active == 1)
                    <a href="/movie/{{$movie->title}}" ><img class="card" src="{{$movie->pictureLink}}" alt="{{$movie->title}}"/></a>
                @endif
            </div>
        @endforeach
        <h2 style="text-align: center"><i><u><b>Coming Soon</b></u></i></h2>
        @if(sizeof($movies_soon) == 0)
            <h2>No New Titles. Check Back Soon for upcoming pictures</h2>
        @else
        @foreach($movies as $movie)
            <div class="cardContainer inline-link">
                @if($movie->is_active == 0)
                    <a href="/movie/{{$movie->title}}" ><img class="card" src="{{$movie->pictureLink}}" alt="{{$movie->title}}"/></a>
                @endif
            </div>
        @endforeach
            @endif
	</div>
	<script>

	</script>
</body>
</html>
