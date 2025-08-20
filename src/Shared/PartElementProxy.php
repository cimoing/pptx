<?php

namespace Imoing\Pptx\Shared;

use Imoing\Pptx\Opc\Package\XmlPart;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property XmlPart $part
 */
class PartElementProxy extends ElementProxy implements ProvidesPart
{
    protected XmlPart $_part;
    public function __construct(BaseOXmlElement $element, XmlPart $part)
    {
        parent::__construct($element);
        $this->_part = $part;
    }

    public function getPart(): XmlPart
    {
        return $this->_part;
    }
}