<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STPositiveFixedPercentage extends STPercentage
{
    public static function validate($value): void
    {
        static::validateFloatInRange($value, 0.0, 1.0);
    }
}