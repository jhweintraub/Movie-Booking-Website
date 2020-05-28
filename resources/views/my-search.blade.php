<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.5 Full Text Search Example</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
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
{{--            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Movies <span class="caret"></span></a>--}}
{{--                <ul class="dropdown-menu">--}}
{{--                    @foreach($all_movies as $movie1)--}}
{{--                        {{$movie1->title}}--}}
{{--                        <li><a href="/movie/{{$movie1->title}}">{{$movie1->title}}</a></li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::User()->isAdmin == 1)--}}
{{--                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Manage Tools<span class="caret"></span></a>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        <li><a href="/nova/resources/users">Users</a></li>--}}
{{--                        <li><a href="/nova/resources/movies">Movies</a></li>--}}
{{--                        <li><a href="/nova/resources/showings">Show Times</a></li>--}}
{{--                        <li><a href="/nova/resources/showrooms">Auditoriums</a></li>--}}
{{--                        <li><a href="/nova/resources/promotions">Promotions</a></li>--}}
{{--                        <li><a href="/nova">Statistics</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endif--}}
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
<div class="container">
    <h1>DawgCinemas Search Page</h1>


    <form method="GET" action="{{ url('my-search') }}">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ old('search') }}">
            </div>
            <div class="col-md-6">
                <button class="btn btn-success">Search</button>
            </div>
        </div>
    </form>
</br>


    <table class="table table-bordered">
        <tr>
            <th>Title</th>
            <th>Director</th>
            <th>Category</th>
            <th>Link</th>
        </tr>
        @if($movies->count())
            @foreach($movies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->director }}</td>
                    <td>{{ $movie->category }}</td>
                    <td><a href="/movie/{{$movie->title}}">Link</a></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4">Result not found.</td>
            </tr>
        @endif
    </table>
</div>
</body>
</html>
