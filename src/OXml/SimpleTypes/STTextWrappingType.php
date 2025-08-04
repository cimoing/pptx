<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STTextWrappingType extends XsdTokenEnumeration
{
    const NONE = 'none';
    const SQUARE = 'square';

    protected static $_members = [
        self::NONE,
        self::SQUARE,
    ];
}