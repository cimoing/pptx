<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STGrouping extends XsdStringEnumeration
{
    const CLUSTERED = 'clustered';
    const PERCENT_STACKED = 'percentStacked';
    const STACKED = 'stacked';
    const STANDARD = 'standard';

    protected static $_members = [
        self::CLUSTERED,
        self::PERCENT_STACKED,
        self::STACKED,
        self::STANDARD,

    ];
}