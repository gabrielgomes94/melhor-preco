<?php

namespace Barrigudinha\Notification\ValueObjects;

use InvalidArgumentException;

class Tags
{
    private array $validTags = [
        'costs',
        'loss',
        'price',
        'products',
        'sales',
        'stock',
        'sync',
        'taxes',
    ];

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
            if (!in_array($tag, $this->validTags, true)) {
                $validTags = implode(', ', $this->validTags);

                throw new InvalidArgumentException("Attribute '{$tag}' is not valid. Use: {$validTags}");
            }

            $this->tags[] = $tag;
        }
    }
}
