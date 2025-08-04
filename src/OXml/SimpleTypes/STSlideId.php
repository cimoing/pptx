<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STSlideId extends XsdUnsignedInt
{
    public static function validate($value): void
    {
        static::validateIntInRange($value, 256,2147483647);
    }
}