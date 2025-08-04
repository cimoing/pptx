<?php

namespace Imoing\Pptx\OXml\XmlChemy;

use DOMElement;
use Imoing\Pptx\Common\BaseObject;

/**
 * @property DOMElement $element
 * @mixin DOMElement
 */
abstract class MetaOXmlElement extends BaseObject
{
    private DOMElement $_element;

    public function __construct(DOMElement $element)
    {
        parent::__construct([]);
        $this->_element = $element;
        $this->init();
    }

    public function getElement(): DOMElement
    {
        return $this->_element;
    }
    /**
     * 初始化属性相关函数
     * @return void
     */
    private function init(): void
    {
        $reflection = new \ReflectionClass($this);

        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            if (str_starts_with($propertyName,"_")) {
                $propertyName = ltrim($propertyName,"_");
            }
            $attributes = $property->getAttributes();
            foreach ($attributes as $attribute) {
                $instance = $attribute->newInstance();
                if ($instance instanceof BaseChildElement || $instance instanceof BaseAttribute) {
                    if ($this instanceof BaseOXmlElement) {
                        $instance->populateClassMembers($this, $propertyName);
                    }
                }
            }
        }
    }

    public function __set(string $name, $value): void
    {
        if (isset($this->_setter[$name])) {
            call_user_func($this->_setter[$name], $this,$value);
            return;
        }
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $value);
        }
        $this->element->{$name} = $value;
    }

    public function __isset(string $name): bool
    {
        return array_key_exists($name, $this->_getter);
    }

    public function __unset(string $name): void
    {
        unset($this->_setter[$name]);
        unset($this->_getter[$name]);
    }

    public function __get(string $name)
    {
        $fun  = $this->_getter[$name] ?? null;
        if ($fun) {
            return $fun($this);
        }
        if (method_exists($this, $getter = 'get' . ucfirst($name))) {
            return $this->$getter();
        }

        if ($this->hasCustomFunction($getter = '_get_' . $name)) {
            return call_user_func($this->_customFunctions[$getter], $this);
        }

        return $this->element->$name;
    }

    public function getProperty(string $name)
    {
        $func = $this->_customProperties[$name] ?? null;
        return $func ? call_user_func($func) : null;
    }

    private array $_getter = [];
    private array $_setter = [];
    public function setGetterSetter(string $name, ?callable $getter, ?callable $setter): void
    {
        if ($getter) {
            $this->_getter[$name] = $getter;
        }
        if ($setter) {
            $this->_setter[$name] = $setter;
        }
    }

    /**
     * @var callable[]
     */
    private array $_customFunctions = [];

    public function addCustomFunction(string $name, callable $function): void
    {
        $this->_customFunctions[$name] = $function;
    }

    public function hasCustomFunction(string $name): bool
    {
        return isset($this->_customFunctions[$name]);
    }

    public function __call(string $name, array $arguments)
    {
        if (isset($this->_customFunctions[$name])) {
            // 第一个参数为当前对象
            array_unshift($arguments, $this);
            return call_user_func_array($this->_customFunctions[$name], $arguments);
        }

        return call_user_func_array([$this->element, $name], $arguments);
    }
}