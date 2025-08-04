<?php

namespace Imoing\Pptx\Shared;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;

class ElementProxy extends BaseObject
{
    protected BaseOXmlElement $_element;
    public function __construct(BaseOXmlElement $element)
    {
        parent::__construct([]);
        $this->_element = $element;
    }

    public function getElement(): BaseOXmlElement
    {
        return $this->_element;
    }
}