<?php

namespace Imoing\Pptx\Util;

use Imoing\Pptx\Util\Length;

class Mm extends Length
{
    public function __construct(float $mm) {
        parent::__construct((int)($mm * self::EMUS_PER_MM));
    }
}