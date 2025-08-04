<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STDirection extends XsdTokenEnumeration
{
    const HORZ = 'horz';
    const VERT = 'vert';

    protected static $_members = [self::HORZ, self::VERT,];
}