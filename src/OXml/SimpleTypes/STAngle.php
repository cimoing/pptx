<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STAngle extends XsdInt
{
    const DEGREE_INCREMENTS = 60000;
    const THREE_SIXTY = 360 * self::DEGREE_INCREMENTS;

    public static function convertFromXml(string $xmlValue): float
    {
        $rot = intval($xmlValue) % self::THREE_SIXTY;

        return floatval($rot) / self::DEGREE_INCREMENTS;
    }

    public static function convertToXml($value): string
    {
        $rot = intval(round($value * self::DEGREE_INCREMENTS)) % self::THREE_SIXTY;
        return strval($rot);
    }

    public static function validate($value): void
    {
        BaseFloatType::validate($value);
    }
}