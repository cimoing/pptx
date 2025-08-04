<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STTargetMode extends XsdString
{
    public static function validate($value): void
    {
        self::validateString($value);
        if (!in_array($value, ['External', 'Internal'])) {
            throw new \ValueError("Value must be one of 'External', 'Internal', got $value");
        }
    }
}