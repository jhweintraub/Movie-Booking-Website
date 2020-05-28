<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class returnTickets extends Notification
{
    use Queueable;


    public $bookingNumber;
    public $seatList;
    public $movie;
    public $dateTime;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bookingNumber, $seatList, $movie, $dateTime)
    {
        $this->bookingNumber = $bookingNumber;
        $this->seatList = $seatList;
        $this->movie = $movie;
        $this->dateTime = $dateTime;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting("Hello")
                    ->line('We\'re Sorry to See you go. Thank you for shopping with DawgCinemas. You Cancelled the Following Booking')
                    ->line('Booking Number: '.$this->bookingNumber)
                    ->line('Movie: '.$this->movie)
                    ->line('Date and Time: '.$this->dateTime->dateTime)
                    ->line('Seat List: '.implode(', ' , $this->seatList))
                    ->salutation('Regards, DawgCinemas');

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
