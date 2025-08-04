<?php

namespace Imoing\Pptx\OXml\XmlChemy;

use Attribute;

#[\Attribute(Attribute::TARGET_PROPERTY)]
class ZeroOrOne extends BaseChildElement
{
    public function populateClassMembers(BaseOXmlElement $elementCls, string $propName, ...$args): void
    {
        parent::populateClassMembers($elementCls, $propName, ...$args);
        $this->addGetter();
        $this->addCreator();
        $this->addInserter();
        $this->addAdder();
        $this->addGetOrAdder();
        $this->addRemover();
    }

    protected function addGetOrAdder(): void
    {
        $func = function (BaseOXmlElement $element): BaseOXmlElement {
            $child = $element->{$this->_propName};
            if ($child === null) {
                $addMethod = [$element, $this->getAddMethodName()];
                $child = call_user_func($addMethod);
            }
            return $child;
        };
        $this->addToClass($this->getGetOrAddMethodName(), $func);
    }

    protected function addRemover(): void
    {
        $func = function (BaseOXmlElement $element): void {
            $children = $element->getElementsByNsTagName($this->_namespaceTagName);
            foreach ($children as $child) {
                $element->removeChild($child);
            }
        };

        $this->addToClass($this->getRemoveMethodName(), $func);
    }

    protected function getGetOrAddMethodName(): string
    {
        return sprintf("get_or_add_%s", $this->_propName);
    }
}