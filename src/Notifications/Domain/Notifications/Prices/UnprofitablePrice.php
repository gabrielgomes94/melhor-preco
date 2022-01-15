<?php

namespace Src\Notifications\Domain\Notifications\Prices;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnprofitablePrice extends Notification
{
    use Queueable;

    private string $priceId;
    private string $productId;
    private string $productName;
    private float $profitValue;
    private float $priceValue;
    private string $store;
    private string $storeSlug;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->priceId = $data['priceId'];
        $this->productId = $data['productId'];
        $this->productName = $data['productName'];
        $this->profitValue = $data['profitValue'];
        $this->priceValue = $data['priceValue'];
        $this->store = $data['store'];
        $this->storeSlug = $data['storeSlug'];
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
        return (new MailMessage)
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
        $title = "Produto {$this->productId} está dando prejuízo no {$this->store}";
        $content = [
            'priceId' => $this->priceId,
            'productId' => $this->productId,
            'productName' => $this->productName,
            'price' => $this->priceValue,
            'profit' => $this->profitValue,
            'store' => $this->store,
            'storeSlug' => $this->storeSlug,
        ];

        return [
            'title' => $title,
            'content' => $content,
            'type' => 'warning',
            'solved_at' => '',
            'tags' => ['preços','prejuízo'],
        ];
    }
}
