<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class XsdUnsignedByte extends BaseIntType
{
    public static function validate($value): void
    {
        static::validateIntInRange($value, 0, 255);
    }
}