<?php

namespace App\Http\Controllers;
use App\Booking;
use App\Card;
use App\Movie;
use App\Review;
use App\Seat;
use App\Showing;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use App\Notifications\returnTickets;

class PostController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }


    public function update_user_info(Request $request) {
        DB::table('users')->where('id', Auth::id())->update([
           'name' => $request['name'],
            'address' => $request['address']
        ]);
        return "It worked!";
    }

    public function create_review(Request $request) {
        $review = new Review();
        logger(print_r($request['movie'], true));
        $review->review = $request['review'];
        $movie = Movie::where('title', $request['movie'])->first();
        $review->movie_id = $movie->id;
//        $movie = DB::table('movies')->where('title',  $request['movie'])->get();
//        $review->movie_id = $movie[0]->id;
        $review->user_id = Auth::id();
        $review->save();
        return $review;
    }

    public function update_card_info(Request $request) {
        logger(print_r($request['expDate'], true));
        logger(print_r($request['cvvNum'], true));

        DB::table('cards')->where('id', $request['id'])->update([
            'nameOnCard' => encrypt($request['cardName']),
            'cardNumber' => encrypt($request['cardNum']),
            'expDate' => encrypt($request['expDate']),
            'cvv' => encrypt($request['cvvNum']),
        ]);
        return $request;
    }

    public function opt_out(Request $request) {
        if ($request['optIn'] == 0) {
            $user = Auth::user();
            $user->promotion_opt_in = 0;
            $user->save();
            return "first conditional";
        }

        else {
            $user = Auth::user();
            $user->promotion_opt_in = 1;
            $user->save();
            return "2nd conditional";
        }
        return $request['optIn'];
    }

    public function change_password(Request $request) {
        if (!Hash::check($request['currPassword'], Auth::user()->password)) {
            return [false];
        }
        else {
            $user = Auth::user();
            $user->password = bcrypt($request['newPassword']);
            $user->save();
            return [true];
        }
    }

    public function delete_card(Request $request) {
        DB::table('cards')->where('id', $request['id'])->delete();
        return "it Worked!";
    }

    public function new_card(Request $request) {
        DB::table('cards')->insert([
            'nameOnCard' => encrypt($request['nameOnCard']),
            'cardNumber' => encrypt($request['cardNum']),
            'expDate' => encrypt($request['expDate']),
            'cvv' => encrypt($request['cvv']),
            'user_id' => Auth::id(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return $request['cvv'];
    }

    public function mySearch(Request $request)
    {
        if($request->has('search')){
            $movies = Movie::search($request->get('search'))->get();
        }else{
            $movies = Movie::get();
        }
        return view('my-search', compact('movies'));
    }

    public function ether_pay(Request $request) {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://etherscan.org',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        //Current Ether Price API
        $response = $client->get('https://api.coinmarketcap.com/v1/ticker/ethereum/');
        $json = \GuzzleHttp\json_decode($response->getBody(), true);

        //Check to make sure Tx_Hash hasn't been used before.
        $payments = DB::table('ether_payments')->where('tx_id', $request['tx_info'])->get()->toArray();
        if (sizeof($payments) != 0) return "Payment Already Used. Try Again with a Different ID";

        //TODO ---- Check against EtherScan api for tx info
        //TODO ---- Add new Row to Table for Eth_Payment Info

        return $json[0];
    }

    public function finalizeCheckout(Request $request) {
        $movie = Movie::where('title', $request['movie'])->first();
        $showing = Showing::where('dateTime', $request['dateTime'])->where('movie_id', $movie->id)->first();
        $cards = DB::table('cards')->get()->toArray();
        $used_card = null;
        foreach ($cards as $card) {
            $card->nameOnCard = decrypt($card->nameOnCard);
            $card->cardNumber = decrypt($card->cardNumber);
            $card->expDate = decrypt($card->expDate);
            $card->cvv = decrypt($card->cvv);

            if ($card->cardNumber == $request['cardNum'] && $card->nameOnCard == $request['nameOnCard']) {
               $used_card = $card;
            }
        }

        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->numChildren = (int) $request['numChildren'];
        $booking->numAdults = (int) $request['numAdults'];
        $booking->numSeniors = (int) $request['numSeniors'];
        $booking->finalPrice = (double) $request['finalPrice'];
        $booking->card_id = $used_card->id;

        $booking_info = [
          'booking' => $booking,
          'user' => Auth::user()
        ];

        $booking->bookingNumber = substr(Hash::make(rand(1000, 999999)), 12, 12);
        $booking->save();

        $numChildrenLeft = (int) $request['numChildren'];
        $numAdultsLeft = (int) $request['numAdults'];
        $numSeniorsLeft = (int) $request['numSeniors'];
        for ($x = 0 ; $x < sizeof($request['seatList']); $x++) {
            $ticket = new Ticket();
            $ticket->seat_id = (int) $request['seatList'][$x];
            $ticket->user_id = Auth::id();
            $ticket->showing_id = $showing->id;
            $ticket->booking_id = $booking->id;
            $ticket->showroom_id = (int) $request['showroom'];
            if ($numChildrenLeft > 0) {
                $ticket->ticket_type_id = 1;
                $numChildrenLeft--;
            }

            else if ($numAdultsLeft > 0) {
                $ticket->ticket_type_id = 2;
                $numAdultsLeft--;
            }

            else {
                $ticket->ticket_type_id = 3;
                $numSeniorsLeft--;
            }
            $ticket->save();

            $seat = Seat::where('number', $ticket->seat_id)->where('showings_id', $showing->id)->first();
            $seat->taken = 1;
            $seat->save();
        }

        return "success";
    }

    public function returnTicketInfo(Request $request) {
        $booking = Booking::where('bookingNumber', $request['bookingNumber'])->first();
        if($booking->user_id != Auth::id()) return "error";
        $tickets = Ticket::where('booking_id', $booking->id)->get();
        $seats = [];
        foreach ($tickets as $ticket) {
            $seat = Seat::where('id', $ticket->seat_id)->first();
            array_push($seats, $seat->number);
            $seat->taken = false;
            $seat->save();
        }
        $showing = Showing::where('id', $tickets[0]->showing_id)->first();
        $movie = Movie::where('id', $showing->id)->first();
        $user = Auth::user();
        $user->notify(new returnTickets($booking->bookingNumber, $seats, $movie->title, $showing));

        $booking->delete();

        return "success";
    }
}
