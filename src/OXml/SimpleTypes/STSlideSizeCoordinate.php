<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

use Imoing\Pptx\Util\Emu;

class STSlideSizeCoordinate extends BaseIntType
{
    public static function convertFromXml(string $xmlValue): Emu
    {
        return new Emu($xmlValue);
    }

    public static function validate($value): void
    {
        static::validateInt($value);
        if ($value < 914400 || $value > 51206400) {
            throw new \ValueError("Value must be in range 914400 to 51206400 inclusive(1-56 inches), got $value");
        }
    }
}