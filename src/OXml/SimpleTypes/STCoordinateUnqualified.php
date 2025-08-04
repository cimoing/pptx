<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STCoordinateUnqualified extends XsdLong
{
    public static function validate($value): void
    {
        static::validateIntInRange($value, -27273042329600, 27273042316900);
    }
}