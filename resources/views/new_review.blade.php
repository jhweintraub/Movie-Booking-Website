<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/home.css') }}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

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
            <li><a href="#">FAQ</a></li>
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
<h1>New Review</h1>

    Review:<br>
    <textarea rows="4" cols="50" id="review"></textarea>
    <br>
    <br>
    Movie:<br>
    <select id="select_movie">
        @foreach ($movies as $movie)
            <option id="movie_picker" value="{{$movie->title}}">{{$movie->title}}</option>
            @endforeach
    </select>
    <br><br>
    <input type="submit" value="Submit" onclick="addReview()">
    <script>
        function addReview() {
            confirm("Are you Sure you want to Add this review?");

            let val_input = {
                review: document.getElementById('review').value,
                movie: document.getElementById('select_movie').value,
            }//review_info

            console.log(val_input)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //post new review to the back end and redirect user to view page so they can see their review
            $.post('http://127.0.0.1:8000/create_review', val_input, function(data, status) {
                console.log(data);
                window.location.replace('http://127.0.0.1:8000/movie/' + document.getElementById('select_movie').value);
            });
        }
    </script>

<p>If you click the "Submit" button, the Your Review will be uploaded to the server</p>

</body>
</html>
