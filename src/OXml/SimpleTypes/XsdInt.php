<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class XsdInt extends BaseIntType
{
    public static function validate($value): void
    {
        static::validateIntInRange($value,  -2147483648, 2147483647);
    }
}