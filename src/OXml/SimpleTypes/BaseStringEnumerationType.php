<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class BaseStringEnumerationType extends BaseStringType
{

    protected static $_members = [];
    public static function validate($value): void
    {
        static::validateString($value);
        if (!in_array($value, static::$_members)) {
            throw new \ValueError("Value must be one of " . implode(', ', static::$_members) . ", got $value");
        }
    }
}