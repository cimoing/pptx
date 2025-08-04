<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STPositiveFixedAngle extends STAngle
{
    public static function convertToXml($value): string
    {
        if ($value < 0.0) {
            $value %= -360;
            $value += 360;
        } elseif ($value > 0) {
            $value %= 360;
        }

        return strval(intval(round($value * self::DEGREE_INCREMENTS)));
    }
}