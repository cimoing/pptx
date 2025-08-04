<?php

namespace Imoing\Pptx\Util;

use Imoing\Pptx\Util\Length;

class Inches extends Length
{
    public function __construct(float $inches) {
        parent::__construct((int)($inches * self::EMUS_PER_INCH));
    }
}