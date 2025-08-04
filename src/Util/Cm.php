<?php

namespace Imoing\Pptx\Util;

use Imoing\Pptx\Util\Length;

class Cm extends Length
{
    public function __construct(float $cm) {
        parent::__construct((int)($cm * self::EMUS_PER_CM));
    }
}