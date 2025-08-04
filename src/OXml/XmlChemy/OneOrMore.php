<?php

namespace Imoing\Pptx\OXml\XmlChemy;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class OneOrMore extends BaseChildElement
{
    public function populateClassMembers(BaseOXmlElement $elementCls, string $propName, ...$args): void
    {
        parent::populateClassMembers($elementCls, $propName, ...$args);
        $this->addListGetter();
        $this->addCreator();
        $this->addInserter();
        $this->addAdder();
        $this->addPublicAdder();
        unset($elementCls, $propName);
    }

    protected function addPublicAdder(): void
    {
        $func = function (BaseOXmlElement $element): BaseOXmlElement {
            $method = [$element, $this->getAddMethodName()];
            return call_user_func($method);
        };

        $this->addToClass($this->getPublicAddMethodName(), $func);
    }

    protected function getPublicAddMethodName(): string
    {
        return sprintf("add_%s", $this->_propName);
    }
}