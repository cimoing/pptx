<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

use Imoing\Pptx\Util\Emu;

class STCoordinate32Unqualified extends XsdInt
{
    public static function convertFromXml($xmlValue): Emu
    {
        return new Emu(intval($xmlValue));
    }
}