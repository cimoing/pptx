<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;

abstract class AbsFill extends BaseOXmlElement
{
    public function getJsonType(): string
    {
        return 'color';
    }

    public function getJsonValue(): mixed
    {
        return '#fff';
    }
}