<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

use Imoing\Pptx\Util\Centipoints;
use Imoing\Pptx\Util\Emu;

class STTextSpacingPoint extends BaseIntType
{
    public static function convertFromXml(string $xmlValue): Centipoints
    {
        return new Centipoints(intval($xmlValue));
    }

    public static function convertToXml($value): string
    {
        $length = new Emu($value);
        return strval($length->getCentipoints());
    }

    public static function validate($value): void
    {
        self::validateIntInRange($value, 0, 20116800);
    }
}