<?php

namespace Imoing\Pptx\Util;

use Imoing\Pptx\Util\Length;

/**
 * 1/100磅
 */
class Centipoints extends Length
{
    public function __construct(int $centipoints) {
        parent::__construct($centipoints * self::EMUS_PER_CENTIPOINT);
    }
}