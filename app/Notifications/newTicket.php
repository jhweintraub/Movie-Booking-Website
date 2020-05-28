<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Endroid\QrCode\QrCode;

class newTicket extends Notification
{
    use Queueable;


    public $dateTime;
    public $showroom;
    public $movie;
    public $seatNumber;
    public $ticket_type;
    public $qrCode;
    public $bookingNum;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($dateTime, $showroom, $movie, $seatNumber, $ticket_type, $bookingNum)
    {
        $this->dateTime = $dateTime;
        $this->showroom = $showroom;
        $this->movie = $movie;
        $this->seatNumber = $seatNumber;
        $this->ticket_type = $ticket_type;
        $this->bookingNum = $bookingNum;
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
                    ->greeting("Ticket Information")
                    ->line('Your new Ticket Information. The Information is as Follows')
                    ->line('Date and Time: '.$this->dateTime)
                    ->line('Showroom: '.$this->showroom)
                    ->line('Movie: '.$this->movie)
                    ->line('Seat Number: '.$this->seatNumber)
                    ->line('Ticket Type: '.$this->ticket_type)
                    ->line('Booking Number: '.$this->bookingNum);
//        TODO ----- Add QR Code - If Time
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
