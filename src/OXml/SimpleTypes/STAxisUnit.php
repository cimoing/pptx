<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STAxisUnit extends XsdDouble
{
    public static function validate($value): void
    {
        parent::validate($value);
        if ($value <= 0) {
            throw new \ValueError("Value must be greater than zero, got $value");
        }
    }
}