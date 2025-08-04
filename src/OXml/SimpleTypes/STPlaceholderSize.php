<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STPlaceholderSize extends XsdTokenEnumeration
{
    const FULL = "full";
    const HALF = "half";
    const QUARTER = "quarter";

    protected static $_members = [self::FULL, self::HALF, self::QUARTER];
}