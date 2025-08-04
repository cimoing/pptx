<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

use Imoing\Pptx\Util\Emu;

class STLineWidth extends XsdInt
{
    public static function convertFromXml($xmlValue): Emu
    {
        return new Emu(intval($xmlValue));
    }

    public static function validate($value): void
    {
        parent::validate($value);
        if ($value < 0 || $value > 20116800) {
            throw new \ValueError("Value must be in range 0 to 20116800 inclusive(0-1584 points), got $value");
        }
    }
}