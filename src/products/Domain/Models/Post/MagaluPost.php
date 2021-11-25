<?php

namespace Src\Products\Domain\Models\Post;

use Src\Products\Domain\Models\Post\Concerns\SecondaryPrice;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;

class MagaluPost extends Post implements HasSecondaryPrice
{
    use SecondaryPrice;
}
