<?php

namespace Imoing\Pptx\Enum\Base;

interface IBaseXmlEnum extends IBaseEnum
{
    public static function fromXml(string $xmlValue);

    public static function toXml(IBaseXmlEnum $value): string;

    public function getXmlValue(): string;
}
