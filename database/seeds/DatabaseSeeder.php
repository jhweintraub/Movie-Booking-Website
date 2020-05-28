<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \App\Showroom;
use \App\TicketType;
use \App\Showing;
use \App\Seat;
use \App\Actor;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->name = "Josh Weintraub";
        $user->email = "jhweintraub@gmail.com";
        $user->password = Hash::make('Jweintraub1!');
        $user->address = "test";
        $user->isAdmin = true;
        $user->promotion_opt_in = true;
        $user->save();

        DB::table('cards')->insert([
            'nameOnCard' => encrypt("Josh Weintraub"),
            'cardNumber' => encrypt("1234"),
            "expDate" => encrypt(12),
            "cvv" => encrypt(13),
            "user_id" => 1
        ]);

        DB::table('cards')->insert([
            'nameOnCard' => (string) encrypt("Joel Spiderman"),
            'cardNumber' => (string) encrypt("3452"),
            "expDate" => (string) encrypt(14),
            "cvv" => (string) encrypt(69),
            "user_id" => 1
        ]);

        DB::table('movies')->insert([
            'title' => 'Baby Driver',
            'rating' => 'PG-13',
            'director' => "Edgar White",
            'producer' => "Your Mom",
            'Synopsis' => "Lorem Ipsum Dol Set Amet",
            'pictureLink' => "https://cdn.shopify.com/s/files/1/1416/8662/products/baby_driver_2017_original_film_art_2000x.jpg?v=1562543900",
            'videoLink' => "https://www.youtube.com/embed/y6120QOlsfU",
            'duration' => 120,
            'Category' => "Action",
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('movies')->insert([
            'title' => 'Blade Runner 2049',
            'rating' => 'R',
            'director' => "Denis Villenue",
            'producer' => "Your Mom",
            'Synopsis' => "Lorem Ipsum Dol Set Amet",
            'Category' => 'Drama',
            'duration' => 120,
            'pictureLink' => "https://cdn.shopify.com/s/files/1/1416/8662/products/blade_runner_2049_2017_advance_original_film_art_9f68118b-43cb-45f1-9743-0d088a1e142c_2000x.jpg?v=1562541365",
            'videoLink' => "https://www.youtube.com/embed/dQw4w9WgXcQ",
            'is_active' => false,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $movie = new \App\Movie();
        $movie->title = "Inception";
        $movie->rating = "PG-13";
        $movie->director = "Christopher Nolan";
        $movie->producer = "John Smith";
        $movie->Synopsis = "Leo Dicaprio does some real confusing stuff with dreams";
        $movie->Category = "Action Sci-Fi";
        $movie->duration = 180;
        $movie->pictureLink = "https://cdn.shopify.com/s/files/1/1416/8662/products/inception_2010_advance_original_film_art_dc7d7689-1e66-41d6-b228-48da4e7b52e4_2000x.jpg?v=1564717627";
        $movie->videoLink = "https://www.youtube.com/embed/L_jWHffIx5E";
        $movie->is_active = false;
        $movie->save();

        $movie2 = new \App\Movie();
        $movie2->title = "The Room";
        $movie2->rating = "PG-13";
        $movie2->director = "Tommy Wisseau";
        $movie2->producer = "Tommy Wisseau";
        $movie2->Synopsis = "I did not hit her, its not true, its bullshit, I did not hit her, I did nahhhht. Oh Hi Mark";
        $movie2->Category = "Comedy";
        $movie2->duration = 120;
        $movie2->pictureLink = "http://www.theroommovie.com/roompics/postera.jpg";
        $movie2->videoLink = "https://www.youtube.com/embed/aekfPU0SwNw";
        $movie2->is_active = false;
        $movie2->save();

        $showroom = new Showroom();
        $showroom->seatNumber = 25;
        $showroom->seatCount = 5;
        $showroom->rowCount = 5;
        $showroom->save();

        $ticketType = new TicketType();
        $ticketType->name = "Child";
        $ticketType->amount = 12;
        $ticketType->save();

        $ticketType = new TicketType();
        $ticketType->name = "Adult";
        $ticketType->amount = 15;
        $ticketType->save();

        $ticketType = new TicketType();
        $ticketType->name = "Senior";
        $ticketType->amount = 13;
        $ticketType->save();

        $promotion = new \App\Promotion();
        $promotion->code = "HI";
        $promotion->discount = 15;
        $promotion->name = "Veterans Day Discount";
        $promotion->isActive = 1;
        $promotion->save();

        $showing = new Showing();
        $showing->dateTime = new DateTime('2019-11-18 12:00:00');
        $showing->showroom_id = 1;
        $showing->movie_id = 1;
        $showing->save();

        for($x = 1; $x <= 25; $x++) {
            $seat = new Seat();
            $seat->number = $x;
            $seat->taken = 0;
            $seat->showings_id = 1;
            $seat->save();
        }

        $actor1 = new Actor();
        $actor1->name = "Michael Cera";
        $actor1->movie_id = 1;
        $actor1->save();

        $actor2 = new Actor();
        $actor2->name = "John Smith";
        $actor2->movie_id = 1;
        $actor2->save();

        $actor3 = new Actor();
        $actor3->name = "John Kusack";
        $actor3->movie_id = 1;
        $actor3->save();

        $actor4 = new Actor();
        $actor4->name = "Tony Bernard";
        $actor4->movie_id = 2;
        $actor4->save();

        $actor4 = new Actor();
        $actor4->name = "Lernernerner DiCapricorn";
        $actor4->movie_id = 3;
        $actor4->save();


        $actor5 = new Actor();
        $actor5->name = "Ellen Page";
        $actor5->movie_id = 3;
        $actor5->save();

        $actor6 = new Actor();
        $actor6->name = "Tommy Wiseau";
        $actor6->movie_id = 4;
        $actor6->save();

        $actor7 = new Actor();
        $actor7->name = "Greg Sestero";
        $actor7->movie_id = 4;
        $actor7->save();
    }
}
