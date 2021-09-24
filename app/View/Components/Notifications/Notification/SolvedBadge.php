<?php

namespace App\View\Components\Notifications\Notification;

use Barrigudinha\Notification\Notification;

class SolvedBadge extends NotificationComponent
{
    private const COMPONENT_PATH = 'components.utils.badge';
    private const SOLVED = 'Resolvido';
    private const UNSOLVED = 'Em aberto';

    protected Notification $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $path = self::COMPONENT_PATH;

        if ($this->notification->isSolved()) {
            return view("{$path}.success", ['status' => self::SOLVED]);
        }

        return view("{$path}.danger", ['status' => self::UNSOLVED]);
    }
}
