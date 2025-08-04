<?php

namespace Imoing\Pptx\OXml\XmlChemy;

use Imoing\Pptx\OXml\Ns\NamespacePrefixedTag;
use Imoing\Pptx\OXml\Ns\NsMap;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class OneAndOnlyOne extends BaseChildElement
{
    public function __construct(string $namespaceTagName)
    {
        parent::__construct($namespaceTagName, []);
    }

    public function populateClassMembers(BaseOXmlElement $elementCls, string $propName, ...$args): void
    {
        parent::populateClassMembers($elementCls, $propName);
        $this->addGetter();
    }

    protected function getGetter(): callable
    {
        return function (BaseOXmlElement $element): BaseOXmlElement {
            $items = $element->getElementsByNsTagName($this->_namespaceTagName);
            if ($items->count() == 0) {
                throw new \Exception(sprintf("No element found for %s", $this->_namespaceTagName));
            }
            return NsMap::castDom($items->item(0));
        };
    }
}