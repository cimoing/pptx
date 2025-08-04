<?php

namespace Imoing\Pptx\Shared;

use Imoing\Pptx\Opc\XmlPart;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property ProvidesPart $parent
 * @property XmlPart $part
 */
class ParentedElementProxy extends ElementProxy implements ProvidesPart
{
    private ProvidesPart $_parent;
    public function __construct(BaseOXmlElement $element, ProvidesPart $part)
    {
        parent::__construct($element);
        $this->_parent = $part;
    }

    public function getParent(): ProvidesPart
    {
        return $this->_parent;
    }

    public function getPart(): XmlPart
    {
        return $this->_parent->getPart();
    }
}