<?php

namespace App\View\Components\Notifications\Inbox\Card;

use App\Services\Notifications\Transformers\Inbox;
use Illuminate\View\Component;

class Card extends Component
{
    private Inbox $inbox;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Inbox $inbox)
    {
        $this->inbox = $inbox;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notifications.inbox.card.card');
    }
}
