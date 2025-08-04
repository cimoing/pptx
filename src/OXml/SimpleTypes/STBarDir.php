<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STBarDir extends XsdStringEnumeration
{
    const BAR = 'bar';
    const COL = 'col';
    protected static $_members = [self::BAR, self::COL];
}