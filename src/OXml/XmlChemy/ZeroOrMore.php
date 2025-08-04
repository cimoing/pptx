<?php

namespace Imoing\Pptx\OXml\XmlChemy;

use Attribute;

#[\Attribute(Attribute::TARGET_PROPERTY)]
class ZeroOrMore extends BaseChildElement
{
    public function populateClassMembers(BaseOXmlElement $elementCls, string $propName, ...$args): void
    {
        parent::populateClassMembers($elementCls, $propName, ...$args);
        $this->addListGetter();
        $this->addCreator();
        $this->addInserter();
        $this->addAdder();
        unset($elementCls->$propName);
    }
}