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
            <li><a href="#">FAQ</a></li>
            <li>
                <input style="margin:8%;" type="text" placeholder="Search.." id="searchBar" name="search">
            </li>
            <li>
                <button style="margin-top:43%; margin-left: 45%; height: 2.5%" onClick="search()" type="submit"><i class="fa fa-search"></i></button>
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
                <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            @endif
        </ul>
    </div>
</nav>
<div style="padding-left: 1%">
<h2>Return Tickets</h2>
<p><i>Warning: Returning Tickets will return every ticket in your booking. Your Credit Card will be refunded</i></p>
<form>
    <input type="text" id="bookingNum" required> Booking Number
    <br>
    <br>
    <button type="submit" onclick="returnTickets()"> Submit</button>
    <script>
        function returnTickets() {
            confirm('Are you sure you want to refund your tickets? This Action cannot be undone')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let val_info = {
                bookingNumber: document.getElementById('bookingNum').value
            }

            $.post('/returnTicketInfo', val_info, (data,success) => {
                console.log(data)
                if (data == "success") alert("Ticket Return Successful. Thank you for using DawgCinemas")
                else if (data == "error") alert("Invalid Request. Booking Not Tied to User. Please Input a Booking Number tied to your account")
            });
        }
    </script>
</form>
</div>
</body>
</html>
