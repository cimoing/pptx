<?php

namespace Imoing\Pptx\Util;

class Px extends Length
{
    public function __construct(float $px) {
        parent::__construct((int)($px * self::EMUS_PER_PX));
    }
}