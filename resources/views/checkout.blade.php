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
                    @foreach($allMovies as $movie_indiv)
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
        </ul>
        <ul class="nav navbar-nav navbar-right">
{{--            <li><a href="checkout.html"><span class="glyphicon glyphicon-shopping-cart"></span> Check Out</a></li>--}}
{{--            <li><a href="signup.html"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>--}}
            <li><a href="/logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container container-fluid">
    <div class="panel panel-default" style="width: 60%; margin: 0 auto;">
        <div class="panel-heading">
            <h4>Order Summary<span><i class="fa fa-shopping-cart"></i></span></h4>
        </div>
        <div class="panel-body">
            <table class="table" style=" width: 100%; color:black; background: #f9f9f9; ">
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Child</td>
                    <td id="numChildren">{{$numChildren}} </td>
                    <td>${{$ticket_prices[0]->Amount}}</td>
                    <td>${{$numChildren * $ticket_prices[0]->Amount}} </td>
                </tr>
                <tr>
                    <td>Adult</td>
                    <td id="numAdults">{{$numAdults}}</td>
                    <td>${{$ticket_prices[1]->Amount}}</td>
                    <td>${{$numAdults * $ticket_prices[1]->Amount}} </td>
                </tr>
                <tr>
                    <td>Senior</td>
                    <td id="numSeniors">{{$numSeniors}}</td>
                    <td>${{$ticket_prices[2]->Amount}}</td>
                    <td>${{$numSeniors * $ticket_prices[2]->Amount}} </td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td></td>
                    <td></td>
                    <td>${{$totalPrice}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Tax: </td>
                    <td>${{$taxes}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Final: </td>
                    <td id="finalPrice">${{$finalPrice}}</td>
                </tr>
            </table>
            <p><i>A $2.5 Surcharge has been added to your bill for processing fees</i></p>
            <input type="text" onchange="check_valid_promo(this)"> Enter Promo Code</input>
            <script>
                let used_promo = false;

                function check_valid_promo(code) {
                    if(used_promo) {
                        used_promo = true;
                        alert("You Have Already Used a Promo Code. Only One-Per-Person Per-Purchase valid")
                        return;
                    }//if

                    $.get('/get_promotions', (data, success) => {
                        console.log(data)
                        if (data.some(e => e.code === code.value)) {
                            /* vendors contains the element we're looking for */
                            var promo = data.filter(e => e.code === code.value)[0];
                            alert("Valid Promo Code. You Just Saved " + promo.discount + "%. Deduction being made from your bill")
                            var element = parseInt(document.getElementById('finalPrice').innerHTML.substr(1))

                            //recalculate new price and update the html to reflect it
                            document.getElementById('finalPrice').innerHTML = '$' + (1-(promo.discount/100))*element;
                        }
                        else alert('Invalid Promo Code. Please Try Again')
                    })//get
                }
            </script>
        </div>
    </div>
</div>
<div class="container container-fluid">
    <div class="panel panel-default" style="width: 60%; margin: 0 auto;">
        <div class="panel-heading">
            <h4>Purchase Information</h4>
        </div>
        <div class="panel-body">
            <form>
                <div class="form-group">
                    <label for="movie_title">Movie</label>
                    <p id="movie_title">{{$movie->title}}</p>
                </div>
                <div class="form-group">
                    <label for="dateTime">Date and Time:</label>
                    <p id="dateTime">{{$dateTime}}</p>
                </div>
                <div class="form-group">
                    <label for="seatList">Seats:</label>
                    <ul id="seatList">
                        @foreach ($seatList as $seat)
                            <li value="{{$seat}}">{{$seat}}</li>
                        @endforeach
                    </ul>
                    </div>
                <div class="form-group">
                    <label for="showroom">Showroom:</label>
                    <p id="showroom">{{$showroom}}</p>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container container-fluid">
    <div class="panel panel-default" style="width: 60%; margin: 0 auto;">
        <div class="panel-heading">
            <h4>Billing Address</h4>
        </div>
        <div class="panel-body">
            <form>
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" class="form-control" id="userName" value="{{$user->name}}" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" value="{{$user->email}}" name="email" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" value="{{$user->address}}" placeholder="Enter address" name="add" required>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container container-fluid">
    <div class="panel panel-default" style="width: 60%; margin: 0 auto;">
        <div class="panel-heading">
            <h4>Payment</h4>
        </div>
        <div style="margin: 10px 10px 10px 20px; padding: 10px 0; font-size: 40px;">
            <i class="fa fa-cc-visa" style="color:navy;"></i>
            <i class="fa fa-cc-amex" style="color:blue;"></i>
            <i class="fa fa-cc-mastercard" style="color:red;"></i>
            <i class="fa fa-cc-discover" style="color:orange;"></i>
        </div>
        <div class="panel-body">
            <form>
                <div class="form-group">
                    <label for="name">Name on Card:</label>
                    <input type="text" class="form-control" id="nameOnCard" value="{{$card->nameOnCard}}" placeholder="Enter full name" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="cnum">Card Number:</label>
                    <input type="text" class="form-control" id="cardNum" value="{{$card->cardNumber}}" placeholder="0000-1111-2222-3333" name="cnum" required>
                </div>
                <div class="form-group">
                    <label for="expm">Expiration Date:</label>
                    <input type="text" class="form-control" id="expDate" value="{{$card->expDate}}" placeholder="01/23" name="expm" required>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" class="form-control" id="cvv" value="{{$card->cvv}}" placeholder="711" name="cvv" required>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="same"> Shipping address same as billing</label>
                </div>
                <button type="submit" onClick="sendToCheckout()"class="btn btn-default">Checkout</button>
                <script>
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    function sendToCheckout() {
                        //Collect the list of the seats available. It's organized in a <ul> so we need to loop through it to an array
                        var foo = document.getElementById('seatList');
                        var seatList = [];
                        var ls = foo.getElementsByTagName('li');
                        for(var x = 0; x < ls.length; x++) {
                            seatList.push(ls[x].value)
                        }

                        //Gather all relevant information
                        let checkout_info = {
                            nameOnCard: document.getElementById('nameOnCard').value,
                            cardNum : document.getElementById('cardNum').value,
                            expDate : document.getElementById('expDate').value,
                            cvv : document.getElementById('cvv').value,
                            movie: '{{$movie->title}}',
                            showroom : '{{$showroom}}',
                            dateTime: '{{$dateTime}}',
                            user_name: document.getElementById('userName').value,
                            email : document.getElementById('email').value,
                            address: document.getElementById('address').value,
                            numChildren: '{{$numChildren}}',
                            numAdults:'{{$numAdults}}',
                            numSeniors: '{{$numSeniors}}',
                            seatList: seatList,
                            finalPrice: '{{$finalPrice}}',
                        };

                        // console.log(checkout_info)
                        //confirm purchase and post to the back end
                        confirm('Are you Sure you want to finalize your purchase?')
                        $.post('/finalizeCheckout', checkout_info, (data, success) => {
                            console.log("this is a test")
                            console.log(data)
                            if (data == "success") alert("Tickets Created! Please Check your Email for Information. Redirecting you to home. Thank you for shoppgin with us today")
                            var newUrl = "/home"
                            window.location.href = newUrl
                            return false;
                        })
                    }
                </script>
            </form>
        </div>
    </div>

</div>
</div>



</body>
</html>
