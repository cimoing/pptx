<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STTextFontSize extends BaseIntType
{
    public static function validate($value): void
    {
        self::validateIntInRange($value, 100, 400000);
    }
}