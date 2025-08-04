<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

use Imoing\Pptx\Util\Emu;

class STPositiveCoordinate extends XsdLong
{
    public static function convertFromXml(string $xmlValue): Emu
    {
        $intValue = parent::convertFromXml($xmlValue);
        return new Emu($intValue);
    }

    public static function validate($value): void
    {
        static::validateIntInRange($value, 0, 27273042316900);
    }
}