<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STStyle extends XsdUnsignedByte
{
    public static function validate($value): void
    {
        self::validateIntInRange($value, 0, 48);
    }
}