<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STOrientation extends XsdStringEnumeration
{
    const MAX_MIN = 'maxMin';
    const MIN_MAX = 'minMax';
    protected static $_members = [
        self::MAX_MIN,
        self::MIN_MAX,
    ];
}