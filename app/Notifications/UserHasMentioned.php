<?php

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserHasMentioned extends Notification
{
    use Queueable;

    private $thread;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Thread $thread)
    {
        $this->thread=$thread;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
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
                     ->subject('New Comment Has Submitted!')
                    ->from("Laravel React")   
                    ->view(
                        'emails.newcomment', ['thread' => $this->thread]
                ); 
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
            "message"=> "YOu have been mentioned in thread "  . $this->thread->title 
        ];
    }
}
