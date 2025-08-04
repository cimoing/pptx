<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class XsdLong extends BaseIntType
{
    public static function validate($value): void
    {
        static::validateIntInRange($value, -9223372036854775808, 9223372036854775807);
    }
}