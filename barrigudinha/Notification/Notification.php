<?php

namespace Barrigudinha\Notification;

use Barrigudinha\Notification\ValueObjects\Tags;
use Barrigudinha\Notification\ValueObjects\Type;
use Carbon\Carbon;

class Notification
{
    private Tags $tags;
    private bool $isSolved;
    private bool $wasReaded;
    private string $id;
    private string $title;
    private string $content;
    private Type $type;
    private Carbon $createdAt;

    public function __construct(
        string $id,
        string $title,
        string $content,
        Tags $tags,
        Type $type,
        Carbon $createdAt,
        bool $isSolved = false,
        bool $wasReaded = false
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->tags = $tags;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->isSolved = $isSolved;
        $this->wasReaded = $wasReaded;
    }

    public static function fromArray(array $data): self
    {
        $tags = $data['tags'] instanceof Tags
            ? $data['tags']
            : new Tags($data['tags']);

        $type = $data['type'] instanceof Type
            ? $data['type']
            : new Type($data['type']);

        return new self(
            $data['id'],
            $data['title'],
            $data['content'],
            $tags,
            $type,
            $data['createdAt'],
            $data['isSolved'],
            $data['wasReaded']
        );
    }

    public function createdAt(): Carbon
    {
        return $this->createdAt;
    }

    public function isSolved(): bool
    {
        return $this->isSolved;
    }

    public function tags(): array
    {
        return $this->tags->get();
    }

    public function wasReaded(): bool
    {
        return $this->wasReaded;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'tags' => $this->tags->get(),
            'type' => (string) $this->type,
            'isSolved' => $this->isSolved,
            'wasReaded' => $this->wasReaded,
            'createdAt' => (string) $this->createdAt,
        ];
    }
}
