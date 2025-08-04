<?php

namespace Imoing\Pptx\OXml\XmlChemy;

interface AttributeType
{
    public static function fromXml(string $xmlValue);

    public static function toXml($value): string;
}