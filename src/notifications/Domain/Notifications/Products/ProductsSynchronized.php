<?php

namespace Src\Notifications\Domain\Notifications\Products;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductsSynchronized extends Notification
{
    use Queueable;

    private int $createdCount;
    private int $updatedCount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(int $createdCount, int $updatedCount)
    {
        $this->createdCount = $createdCount;
        $this->updatedCount = $updatedCount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'title' => 'Produtos sincronizados em ' . (string) Carbon::now(),
            'content' => [
                'created' => $this->createdCount,
                'updated' => $this->updatedCount,
            ],
            'type' => 'info',
            'solved_at' => Carbon::now(),
            'tags' => ['produtos','sincronização'],
        ];
    }
}
