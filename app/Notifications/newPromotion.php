<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class newPromotion extends Notification
{
    use Queueable;

    protected $code;
    protected $discount;
    protected $name;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code, $discount, $name)
    {
        $this->code = $code;
        $this->discount = $discount;
        $this->name = $name;
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
                    ->subject('Save Money NOW!')
                    ->greeting('New Promotion Alert')
                    ->line('Use Promo Code: '.$this->code.' to save '.$this->discount.'% at checkout')
                    ->action('Book your Next Movie', url('/'))
                    ->salutation('Thank you for Using DawgCinemas');
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
