<?php

namespace Src\Products\Domain\Post;

use Src\Products\Domain\Post\Concerns\SecondaryPrice;
use Src\Products\Domain\Post\Contracts\HasSecondaryPrice;

class MercadoLivrePost extends Post implements HasSecondaryPrice
{
    use SecondaryPrice;
}
