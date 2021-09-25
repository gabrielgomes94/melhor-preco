<?php

namespace Barrigudinha\Notification\ValueObjects;

class Tags
{
    private array $tags;

    public function __construct(array $tags)
    {
        $this->set($tags);
    }

    public function get(): array
    {
        return $this->tags;
    }

    private function set(array $tags): void
    {
        foreach ($tags as $tag) {
            $this->tags[] = $tag;
        }
    }
}
