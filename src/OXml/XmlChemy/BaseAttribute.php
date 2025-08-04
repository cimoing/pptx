<?php

namespace Imoing\Pptx\OXml\XmlChemy;

abstract class BaseAttribute
{
    protected string $_attrName;

    /**
     * @var string|AttributeType 值类型对应类
     */
    protected string|AttributeType $_simpleType;
    public function __construct(string $attrName, string|AttributeType $simpleType )
    {
        $this->_attrName = $attrName;
        $this->_simpleType = $simpleType;
    }


    private BaseOXmlElement $_element;
    private string $_propName;
    public function populateClassMembers(BaseOXmlElement $elementObj, string $propName): void
    {
        $this->_element = $elementObj;
        $this->_propName = $propName;
        $this->addAttrProperty();
    }

    private function addAttrProperty(): void
    {
        $this->_element->setGetterSetter($this->_propName, $this->getGetter(), $this->getSetter());
    }

    protected function getClarkName(): string
    {
        return $this->_attrName;
    }

    abstract protected function getGetter(): ?callable;

    abstract protected function getSetter(): ?callable;
}