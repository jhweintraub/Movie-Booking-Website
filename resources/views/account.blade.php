<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$(function(){
			$("#datepicker").datepicker();
		});
	</script>

	<title>Dawg Cinemas: Lord of the Rings</title>
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
                            //redirect to search
                            let info = document.getElementById('searchBar').value
                            window.location.href = 'http://127.0.0.1:8000/my-search/?search=' + info;
                        }//search
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

	<div class="main">
		<div class = "panel panel-default" >

			<div class = "panel-heading"><h3>Account Information</h3></div>
				<div class="panel-body">
					<h4 style="display:inline-block">Name:</h4>
					<p style="display:inline-block"> {{$account->name}} </p>
					<br class="s">

					<h4 style="display:inline-block">Address:</h4>
					<p style="display:inline-block">
                        @if ($account->address == null)
                                {{"*No Address Provided*\n"}}</p>
                                                        @else {{$account->address}}
                        @endif
					<br class="s">
					<div></div>
                    <h4 style="display:inline-block">Email:</h4>
					<p style="display:inline-block"> {{$account->email}} </p>
                    <br class="s">
                    <h4 style="display:inline-block">Promo Emails:</h4>
                    <p style="display:inline-block"> {{$account->promotion_opt_in == 1 ? "Yes" : "No"}} </p>
                    <br class="s">
                    <button style="display: block" onclick="switchToAcc();">Edit Account</button>
				</div>
		</div>
		<div class ="panel panel-default">
			<div class = "panel-heading"><h3>Banking Information</h3></div>
			<div class="panel-body">
                <h4 style="display:inline-block">Name on Account:</h4>
                <p style="display:inline-block"> {{$account->name}} </p>
                <br class="s">
                @foreach ($cards as $card)
                    <h4 style="display:inline-block">Card ID:</h4>
                    <p style="display:inline-block"> {{$card->id}} </p>
                    <br class="s">
                    <h4 style="display:inline-block">Name on Card:</h4>
                    <p style="display:inline-block"> {{$card->nameOnCard}} </p>
                    <br class="s">
                    <h4 style="display:inline-block">Credit Card No.:</h4>
					<p style="display:inline-block"> {{$card->cardNumber}} </p>
					<br class="s">
					<h4 style="display:inline-block">Exipiration No.:</h4>
					<p style="display:inline-block"> {{$card->expDate}} </p>
					<br>
					<h4 style="display:inline-block">CVV No.:</h4>
					<p style="display:inline-block"> {{$card->cvv}} </p>
                    <br>
                    <br>
                @endforeach
					<button style="display: block" class="editBtn" onclick="switchToBac();">Edit Banking</button>
			</div>
		</div>
	</div>

        <div class ="panel panel-default">
            <div class = "panel-heading"><h3>Change Password</h3></div>
            <div class="panel-body">
                <form style="width: 25% ! important; margin: 10px;">
                        <label for="currPassword">Current Password:</label>
                        <input type="password"  name="currPassword" id='currPassword' required>
                    <br>
                    <br>
                    <label for="newPassword">New Password:</label>
                    <input type="password" name="newPassword" id='newPassword' required>
                <br>
                <button style="display: block" class="editBtn" onclick="changePassword();">Change Password</button>
                    <script>
                        function changePassword() {
                            confirm("Are you Sure you want to change your password?")
                            //collect passwords
                            let val_input = {
                                currPassword: document.getElementById('currPassword').value,
                                newPassword: document.getElementById('newPassword').value,
                            }//val_input

                            //post it to the back end to change
                            $.post('http://127.0.0.1:8000/change_password', val_input, function(data, status) {

                                //if it changes correctly let the user know, if not
                                if (data[0] == true) alert("Password Successfully Changed");
                                else alert("Password Change Failed. Current Password Invalid");
                            });//post
                        }//changePassword


                    </script>
                </br>
                    <h4 style="display:inline-block">Promo Emails:</h4>
                    <input onclick="changePromo_opt_in()" id="optIn" type="checkbox" @if($account->promotion_opt_in) checked @endif> @if($account->promotion_opt_in)Opted In @else Opted Out @endif
                    <script>
                        function changePromo_opt_in() {
                            //This code is big brain - I have no idea why it only works this way but it does - DO NOT CHANGE
                            //If you change this then the values are gonna get flipped and only in weird situations I can't figure out the source of
                            var value;
                            if (document.getElementById('optIn').checked == true) {
                                value = 1;
                            }
                            else value = 0;
                            let box_status = {
                                optIn: value
                            };

                            //Post new Info to the back-end
                            $.post('http://127.0.0.1:8000/optOut', box_status, function(data, status) {
                                // console.log("response: " + data)
                                location.reload()
                            });
                        }//changePromo_opt_in
                    </script>
                </form>
                    </div>
        </div>



        </div>
        <div class ="panel panel-default">
            <div class = "panel-heading"><h3>Order History</h3></div>
            <div class="panel-body">
                <form style="width: 25% ! important; margin: 10px;">
                    @if(sizeof($tickets) == 0)
                        <h4>No order History to Display. Book Your Tickets now!</h4>
                @endif
                    @foreach ($tickets as $ticket)
                        <h4 style="display:inline-block">Movie: </h4>
                        <p style="display:inline-block"><a href="/movie/{{$ticket->showing->movie->title}}"> {{$ticket->showing->movie->title}} </a></p>
                        <br class="s">

                        <h4 style="display:inline-block">Ticket Type: </h4>
                        <p style="display:inline-block"> {{$ticket->TicketType->Name}} </p>
                        <br class="s">

                        <h4 style="display:inline-block">Seat #: </h4>
                        <p style="display:inline-block"> {{$ticket->seat->number}} </p>
                        <br class="s">

                        <h4 style="display:inline-block">Showroom: </h4>
                        <p style="display:inline-block"> {{$ticket->showroom->id}} </p>
                        <br class="s">

                        <h4 style="display:inline-block">Showing Date & Time: </h4>
                        <p style="display:inline-block"> {{$ticket->showing->dateTime}} </p>
                        <br class="s">

                        <h4 style="display:inline-block">Booked At: </h4>
                        <p style="display:inline-block"> {{$ticket->created_at}} </p>
                        <br class="s">

                        <h4 style="display:inline-block">Booking #: </h4>
                        <p style="display:inline-block"> {{$ticket->booking->bookingNumber}} </p>
                        <br class="s">

                        <h4 style="display:inline-block">Price : </h4>
                        <p style="display:inline-block"> ${{$ticket->booking->finalPrice}} </p>
                        <br class="s">
                        <br class="s">
                        <br class="s">


                    @endforeach
                </form>
            </div>
        </div>



        </div>

	<div class="editAccount" style="display: none;">
		<div class ="panel panel-default">
			<div class = "panel-heading"><button onclick="switchToAcc();" > < </button>
			<h4 style="display:inline-block;">Update Personal Information</h4>
			</div>
			<div class="panel-body">
			<form>
				<div class="form-group">
				<label for="First Name">Name:</label>
				<input type="text" value='{{$account->name}}' name="First Name" id="name_field"required> </input>
				</div>
                <div class="form-group">
                    <label for="Address">Address:</label>
                    @if ($account->address != null) <input type="text" value="{{$account->address}}" name="address" id="address_field" required>
                        @else <input type="text" value="No Address Known" name="address" id="address_field" required>
                    @endif
                </div>
				<button onclick="confirmChanges_user_info()">Submit Changes</button>
			</form>
			</div>
		</div>
	</div>

	<div class="editBanking" style="display: none;">
	<div class ="panel panel-default">
		<div class = "panel-heading"><button class="backbutton" onclick="switchToBac();"> < </button>
			<h4 style="display:inline-block;">Banking Information</h4>
		</div>
		<div class = "panel-body">
				<div class="icon-container">
					<label for="cards">Accepted Cards</label>
					  <i class="fa fa-cc-visa" style="color:navy; padding: 5px;"></i>
					  <i class="fa fa-cc-amex" style="color:blue;  padding: 5px;"></i>
					  <i class="fa fa-cc-mastercard" style="color:red;  padding: 5px;"></i>
					  <i class="fa fa-cc-discover" style="color:orange;  padding: 5px;"></i>
				</div>
                @foreach ($cards as $card)
				<form style="width: 25% ! important; margin: 5px;">
					<div class="form-group">
					<label for="accName">Name on Card:</label>
					<input type="text" value='{{$card->nameOnCard}}' name="accName" id='{{$card->nameOnCard}}' required>
					</div>
					<div class="form-group">
					<label for="accNum">Credit Card Number:</label>
					<input type="text" value='{{$card->cardNumber}}' name="accNum" id='{{$card->cardNumber}}' required>
					</div>
					<div class="form-group">
					<label for="accRou">Expiration:</label>
					<input type="text" value='{{$card->expDate}}' name="accExp" id='{{$card->expDate}}' required>
					</div>
					<div class="form-group">
					<label for="accSec">CVV:</label>
					<input type="text" value='{{$card->cvv}}' name="accCvv" id='{{$card->cvv}}' required>
					</div>
                    {{$card->expDate}}
                    {{$card->cvv}}
                    <button onclick="confirmChanges_card('{{$card->nameOnCard}}', '{{$card->id}}', '{{$card->cardNumber}}', '{{$card->expDate}}', '{{$card->cvv}}')">Edit</button>
                    <button onclick="confirmDelete_card('{{$card->id}}')">Delete</button>
                    <script>
                        function confirmChanges_card(nameOnCard, id, cardNum, expDate, cvv){
                            confirm('Changes to account are being requested. Confirm action?');

                            let val_input = {
                                id: id,
                                cardName: document.getElementById(nameOnCard).value,
                                cardNum: document.getElementById(cardNum).value,
                                expDate: document.getElementById(expDate).value,
                                cvvNum: document.getElementById(cvv).value,
                            }//val_input

                            //collect form info and post it to the back end to have it changed in the DB

                            console.log(val_input)
                            $.post('http://127.0.0.1:8000/change_user_card_info', val_input, function(data, status) {
                                console.log(data)
                                console.log(status)
                            });//post
                            return true;
                        }//confirmCard_changes

                        //Collect ID of the card to delete and post it to the back end
                        function confirmDelete_card(id) {
                            let val_input = {
                                id: id
                            }//let

                            $.post('http://127.0.0.1:8000/delete_card', val_input, function(data, status) {
                                console.log(data)
                                console.log(status)
                            });//post
                        }//confirmDelete_card()

                    </script>
                </form>
                @endforeach
            <br>

            @if (count($cards) <= 3)
            <form style="width: 25% ! important; margin: 5px;">
                <h3>New Card Info</h3><br>
                <div class="form-group">
                    <label for="accNum">Name on Card:</label>
                    <input type="text" placeholder='' name="accNum" id='newCardName' required>
                </div>
                <div class="form-group">
                        <label for="accNum">Credit Card Number:</label>
                        <input type="text" placeholder='' name="accNum" id='newCardNum' required>
                    </div>
                    <div class="form-group">
                        <label for="accRou">Expiration:</label>
                        <input type="text" placeholder="" name="accExp" id='newexpDate' required>
                    </div>
                    <div class="form-group">
                        <label for="accSec">CVV:</label>
                        <input type="text" placeholder="" name="accSec" id='newcvv' required>
                    </div>
                    <button onclick="addNewCard()">Add Card</button>
                </form>
                @endif
		</div>
		</div>
	</div>
	<script>
	function switchToAcc(){
		if($('.main').is(":visible")){
			$('.main').hide();
			$('.editAccount').show();
		}
		else{
			$('.editAccount').hide();
			$('.main').show();
		}
	}

	function switchToBac(){
		if($('.main').is(":visible")){
			$('.main').hide();
			$('.editBanking').show();
		}
		else{
			$('.editBanking').hide();
			$('.main').show();
		}
	}

	//Handles the CSRF token management - idk what this line actually does but I know that the post requests dont work without it
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }//headers
    });

	function confirmChanges_user_info() {
        confirm('Changes to account are being requested. Confirm action?');

        let val_input = {
            address: document.getElementById('address_field').value,
            name: document.getElementById('name_field').value,
        }

        console.log(val_input)
        $.post('http://127.0.0.1:8000/change_user_personal_info', val_input, function (data, status) {
            console.log(data)
            console.log(status)
        });
    }//confirmChanges_user_info

    function addNewCard() {
        confirm('Changes to account are being requested. Confirm action?');
        let val_input = {
            nameOnCard: document.getElementById('newCardName').value,
            cardNum: document.getElementById("newCardNum").value,
            expDate: document.getElementById("newexpDate").value,
            cvv: document.getElementById("newcvv").value
        }//val_input

        $.post('http://127.0.0.1:8000/addNewCard', val_input, function(data, status) {
            console.log(data)
            console.log(status)
        });
    }//addNewCard
	</script>
	</body>
</html>

