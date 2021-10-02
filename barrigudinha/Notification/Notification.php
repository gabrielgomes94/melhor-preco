<?php

namespace Barrigudinha\Notification;

use Barrigudinha\Notification\ValueObjects\Tags;
use Carbon\Carbon;

class Notification
{
    private Tags $tags;
    private bool $isSolved;
    private bool $isReaded;
    private string $id;
    private string $title;
    private string $content;
    private Carbon $createdAt;
    private ?Carbon $readAt;
    private ?Carbon $solvedAt;

    public function __construct(
        string $id,
        string $title,
        string $content,
        Tags $tags,
        Carbon $createdAt,
        ?Carbon $solvedAt,
        ?Carbon $readAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->tags = $tags;
        $this->createdAt = $createdAt;
        $this->solvedAt = $solvedAt;
        $this->readAt = $readAt;
    }

    public static function fromArray(array $data): self
    {
        $tags = $data['tags'] instanceof Tags
            ? $data['tags']
            : new Tags($data['tags']);

        return new self(
            $data['id'],
            $data['title'],
            $data['content'],
            $tags,
            $data['createdAt'],
            $data['solvedAt'],
            $data['readAt'],
        );
    }

    public function createdAt(): Carbon
    {
        return $this->createdAt;
    }

    public function isSolved(): bool
    {
        return (bool) $this->solvedAt;
    }

    public function tags(): array
    {
        return $this->tags->get();
    }

    public function isRead(): bool
    {
        return (bool) $this->readAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'tags' => $this->tags->get(),
            'isSolved' => $this->isSolved(),
            'isReaded' => $this->isRead(),
            'createdAt' => (string) $this->createdAt,
        ];
    }
}
