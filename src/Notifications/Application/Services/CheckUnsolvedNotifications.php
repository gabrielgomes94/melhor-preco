<?php

namespace Src\Notifications\Application\Services;

use Illuminate\Foundation\Application;
use Src\Notifications\Domain\Contracts\Repository\Repository;
use Src\Notifications\Domain\Contracts\Rules\Rule;
use Src\Notifications\Domain\Notifications\Prices\UnprofitablePrice as UnprofitablePriceNotification;
use Src\Notifications\Domain\Rules\UnprofitablePrice as UnprofitablePriceRule;
use Src\Notifications\Domain\Contracts\Services\CheckUnsolvedNotifications as CheckUnsolvedNotificationsInterface;
use Src\Notifications\Infrastructure\Repositories\Options\NoOptions;

class CheckUnsolvedNotifications implements CheckUnsolvedNotificationsInterface
{
    private Repository $notificationRepository;
    private Application $application;

    private array $mapper = [
        UnprofitablePriceNotification::class => UnprofitablePriceRule::class,
    ];

    public function __construct(Repository $notificationRepository, Application $application)
    {
        $this->notificationRepository = $notificationRepository;
        $this->application = $application;
    }

    public function check(): void
    {
        $notifications = $this->notificationRepository->list(new NoOptions([]));

        foreach ($notifications->list() as $notification) {
            if (!$rule = $this->getRule($notification->type())) {
                continue;
            }

            if (!$rule->isSolved($notification->data)) {
                continue;
            }

            $notification->markAsSolved();
        }
    }

    private function getRule(string $type): ?Rule
    {
        if (!$rule = $this->mapper[$type] ?? null) {
            return null;
        }

        return $this->application->make($rule);
    }
}
