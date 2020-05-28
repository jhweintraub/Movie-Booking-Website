<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Movie;
use App\Showing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Endroid\QrCode\QrCode;


class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            $movie = DB::table('movies')->get()->toArray();
            $movies_now = DB::table('movies')->where('is_active', '=', 1)->get()->toArray();
            $movies_soon = DB::table('movies')->where('is_active', '=', 0)->get()->toArray();
        return view('home', ['movies' => $movie, 'movies_now' => $movies_now, 'movies_soon' => $movies_soon]);
    }

    public function admin_nova() {
        if (!Auth::check()) return redirect('/login');
        else {
            $this->middleware('verified');
            $this->middleware('auth');
            if (Auth::User()->isAdmin == 1) return redirect('/nova');
            else return redirect('/privilege_error');
        }
    }

    public function privilege_error() {
        return view('privilege_error');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    public function account() {
        $this->middleware('verified');

        $movie = DB::table('movies')->get()->toArray();

        //Decrypt the Info from the Database
            $cards = DB::table('cards')->where('user_id', Auth::id())->get();
            foreach ($cards as $card) {
                $card->nameOnCard = decrypt($card->nameOnCard);
                $card->cardNumber = decrypt($card->cardNumber);
                $card->expDate = decrypt($card->expDate);
                $card->cvv = decrypt($card->cvv);
            }

            $tickets = Auth::user()->tickets;
            return view('account', ['account' => Auth::user(), 'cards' => $cards, 'tickets' => $tickets, 'movies' => $movie]);
    }



    public function checkout() {
        $cards = DB::table('cards')->where('user_id', Auth::id())->get()->toArray();
            $cards[0]->nameOnCard = decrypt($cards[0]->nameOnCard);
            $cards[0]->cardNumber = decrypt($cards[0]->cardNumber);
            $cards[0]->expDate = decrypt($cards[0]->expDate);
            $cards[0]->cvv = decrypt($cards[0]->cvv);
        return view('checkout', ['user' => Auth::user(), 'card' => $cards[0]]);
    }

    public function init_checkout($movie, $dateTime, $numChildren, $numAdults, $numSeniors, $seatList) {
        $this->middleware('verified');

        $NumChildren = $numChildren;
        $NumAdults = $numAdults;
        $NumSeniors = $numSeniors;

        $ticket_prices = DB::table('ticket_types')->get()->toArray();

        $childrenPrice = ($NumChildren * $ticket_prices[0]->Amount);
        $adultsPrice = ($NumAdults * $ticket_prices[1]->Amount);
        $seniorsPrice = ($NumSeniors * $ticket_prices[2]->Amount);
        $totalPrice = $childrenPrice + $adultsPrice + $seniorsPrice;

        $taxes = .07*$totalPrice;
        $finalPrice = (1.07*$totalPrice)+2.5;

        $promotions = DB::table('promotions')->where('isActive', 1)->get();

        $movies = Movie::where('title', $movie)->get();
        logger(print_r($movies[0], true));


        $showing_info = Showing::where('movie_id', $movies[0]->id)->first();//->where('dateTime', $dateTime)->first();
        $allMovies = Movie::get();

        //Credit Card Info
        $cards = DB::table('cards')->where('user_id', Auth::id())->get()->toArray();
        $cards[0]->nameOnCard = decrypt($cards[0]->nameOnCard);
        $cards[0]->cardNumber = decrypt($cards[0]->cardNumber);
        $cards[0]->expDate = decrypt($cards[0]->expDate);
        $cards[0]->cvv = decrypt($cards[0]->cvv);

        return view('/checkout', [
            'allMovies' => $allMovies,
            'numChildren' => $numChildren,
            'numAdults' => $numAdults,
            'numSeniors' => $numSeniors,
            'childrenPrice' => $childrenPrice,
            'adultsPrice' => $adultsPrice,
            'seniorsPrice' => $seniorsPrice,
            'card' => $cards[0],
            'user' => Auth::user(),
            'totalPrice' => $totalPrice,
            'finalPrice' => $finalPrice,
            'taxes' => $taxes,
            'promotions' => $promotions,
            'movie' => $movies[0],
            'dateTime' => $dateTime,
            'seatList' => explode(',', $seatList),
            'ticket_prices' => $ticket_prices,
            'showroom' => $showing_info->showroom_id
        ]);
    }

    public function new_review() {
        $this->middleware('verified');
        $movies = DB::table('movies')->get();
        return view('new_review', ['movies' => $movies]);
    }

    public function getPromotions() {
        return DB::table('promotions')->where('isActive', 1)->get();
    }

    public function returnTickets() {
        $this->middleware('verified');
        $movie = DB::table('movies')->get()->toArray();

        return view('return', ['movies' => $movie]);
    }

}
