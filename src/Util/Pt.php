<?php

namespace Imoing\Pptx\Util;

use Imoing\Pptx\Util\Length;

class Pt extends Length
{
    public function __construct(float $pt) {
        parent::__construct((int)($pt * self::EMUS_PER_PT));
    }
}