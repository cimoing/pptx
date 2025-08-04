<?php

namespace Imoing\Pptx\OXml\XmlChemy;

abstract class FakeDomElement
{
    protected BaseOXmlElement $_element;

    public function __construct(BaseOXmlElement $element)
    {
        $this->_element = $element;
    }
}