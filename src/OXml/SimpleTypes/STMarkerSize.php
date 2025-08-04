<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STMarkerSize extends XsdUnsignedByte
{
    public static function validate($value): void
    {
        static::validateIntInRange($value, 2, 72);
    }
}