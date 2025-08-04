<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class XsdUnsignedInt extends BaseIntType
{
    public static function validate($value): void
    {
        static::validateIntInRange($value, 0, 4294967295);
    }
}