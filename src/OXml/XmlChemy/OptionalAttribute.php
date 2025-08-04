<?php

namespace Imoing\Pptx\OXml\XmlChemy;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class OptionalAttribute extends BaseAttribute
{
    /**
     * @var mixed|null 默认值
     */
    private mixed $_default;
    public function __construct(string $attrName, string|AttributeType $simpleType, $default = null)
    {
        parent::__construct($attrName, $simpleType);
        $this->_default = $default;
    }

    protected function getGetter(): ?callable
    {
        return function (BaseOXmlElement $element) {
            $strVal = null;
            if ($element->hasAttribute($this->getClarkName())) {
                $strVal = $element->getAttribute($this->getClarkName());
            }

            if (is_null($strVal)) {
                return $this->_default;
            }
            return call_user_func([$this->_simpleType, 'fromXml'], $strVal);
        };
    }

    protected function getSetter(): ?callable
    {
        return function (BaseOXmlElement $element, $value) {
            if ($value === $this->_default) {
                if ($element->hasAttribute($this->getClarkName())) {
                    $element->removeAttribute($this->getClarkName());
                }
                return;
            }
            $strVal = call_user_func([$this->_simpleType,'toXml'], $value);
            $element->setAttribute($this->getClarkName(), $strVal);
        };
    }
}