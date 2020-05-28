<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <title>Seat Selection</title>
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
                    @foreach($movie_list as $movie)
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
                <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            @endif
        </ul>
    </div>
</nav>
<div style="padding-left: 1%">
    <div style="width: 15%;">
        <h1  style="padding-left:25%; border: solid #0b2e13 1px;">Screen</h1>
    </div>


@for($row = 0; $row < $showroom->rowCount; $row++)
    @for($seat = 0; $seat < $showroom->seatCount; $seat++)
        @if ($seats[($row*$showroom->rowCount) + $seat]->taken == 0)
            <button type="button"  onclick="addToList(this)" id="{{$seats[($row*$showroom->rowCount) + $seat]->number}}" class="btn btn-primary test p-3">{{$seats[($row*$showroom->rowCount) + $seat]->number}}</button>
        @else
            <button type="button" id="{{$seats[($row*$showroom->rowCount) + $seat]->number}}" class="btn btn-danger test p-3">{{$seats[($row*$showroom->rowCount) + $seat]->number}}</button>
            @endif
    @endfor
    <br>
    @endfor
<br>
<form>
    @foreach ($ticket_type as $ticket)
    <input type="number" value="0" min="0" max="5" id="{{$ticket->Name}}"> {{$ticket->Name}}: ${{$ticket->Amount}}
        <br>
        @endforeach
        <br>
    <script>
        let seatList = [];

        function addToList(seat) {

            //If Seat is in selected by you but you want to de-select it - call deselect method and exit
            if(seat.classList.contains('btn-danger')) {
                removeFromList(seat);
                return;
            }//if

            //flip the seat color and add it to the list of seats selected
            seat.classList.remove('btn-primary');
            seat.classList.add('btn-danger')
            seatList.push(seat.id);

        }//addToList()

        function removeFromList(seat) {

            //Flip Color of Seat
            seat.classList.remove('btn-danger');
            seat.classList.add('btn-primary')

            //Remove it from list
            for(let i = 0; i < seatList.length; i++){
                if (seatList[i] === seat.id) {
                    seatList.splice(i, 1);
                }//if
            }//for
        }//removeFromList()


        function sendToCheckout() {
            //Get Values of Numbers
            var numChildren = parseInt(document.getElementById('Child').value)
            var numAdults = parseInt(document.getElementById('Adult').value)
            var numSeniors = parseInt(document.getElementById('Senior').value)

            if ((numChildren + numAdults + numSeniors) != seatList.length) {
                alert('Invalid Ticket Amounts. Please Make Sure the Number of seats selected match the number of ticket-typed seats')
                return;
            }

            if((numChildren + numAdults + numSeniors) == 0) {
                alert('Invalid Amount. Please Select at least one seat and ticket to continue')
                return;
            }

            //Redirect you to the checkout screen with URL parameters
            var newUrl = "http://127.0.0.1:8000/init_checkout/{{$movies}}/{{$showing_info->dateTime}}/" + numChildren + '/' + numAdults + '/' + numSeniors + '/' + seatList;
            console.log(newUrl)
            window.location.href = newUrl
            return false;
        }//sendToCheckout()
    </script>
</form>
    <p><i>Click Submit to be redirected to the checkout page</i></p>
    <p><i>Children Tickets are for Ages 13 and Under and Seniors is Ages 65+</i></p>
    <button onclick="sendToCheckout()" type="reset">Submit</button>
</div>

</body>
</html>
