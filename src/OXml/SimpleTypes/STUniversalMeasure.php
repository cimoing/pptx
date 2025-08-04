<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

use Imoing\Pptx\Util\Emu;

class STUniversalMeasure extends BaseSimpleType
{
    public static function convertFromXml(string $xmlValue): Emu
    {
        $floatPart = substr($xmlValue, 0, -2);
        $unitPart = substr($xmlValue, -2);
        $quantity = floatval($floatPart);
        $multiplier = [
            'mm' => 36000,
            'cm' => 360000,
            'in' => 914400,
            'pt' => 12700,
            'pc' => 152400,
            'pi' => 152400,
        ][$unitPart];
        return new Emu(intval(round($quantity * $multiplier)));
    }
}