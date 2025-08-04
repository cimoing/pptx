<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class XsdUnsignedShort extends BaseIntType
{
    public static function validate($value): void
    {
        static::validateIntInRange($value, 0, 65535);
    }
}