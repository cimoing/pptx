<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STLayoutMode extends XsdStringEnumeration
{
    const EDGE = 'edge';
    const FACTOR = 'factor';

    protected static $_members = [
        self::EDGE,
        self::FACTOR,
    ];
}