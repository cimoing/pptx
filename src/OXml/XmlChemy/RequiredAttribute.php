<?php

namespace Imoing\Pptx\OXml\XmlChemy;

use Attribute;

#[\Attribute(Attribute::TARGET_PROPERTY)]
class RequiredAttribute extends BaseAttribute
{
    protected function getGetter(): ?callable
    {
        return function (BaseOXmlElement $element): mixed {
            $val = null;
            if ($element->hasAttribute($this->_attrName)) {
                $val = $element->getAttribute($this->_attrName);
            }

            if (is_null($val)) {
                throw new \Exception("required {$this->_attrName} attribute not present on element {$element->tagName}");
            }

            return call_user_func([$this->_simpleType,'fromXml'], $val);
        };
    }

    protected function getSetter(): ?callable
    {
        return function (BaseOXmlElement $element, mixed $value) {
            $element->setAttribute($this->_attrName, call_user_func([$this->_simpleType,'toXml'], $value));
        };
    }
}