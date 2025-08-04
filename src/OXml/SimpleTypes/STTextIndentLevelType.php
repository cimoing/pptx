<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STTextIndentLevelType extends BaseIntType
{
    public static function validate($value): void
    {
        self::validateIntInRange($value, 0, 8);
    }
}