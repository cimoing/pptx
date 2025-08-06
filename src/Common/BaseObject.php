<?php

namespace Imoing\Pptx\Common;

class BaseObject
{

    private array $_properties = [];

    public function __construct(array $properties = [])
    {
        $this->_properties = $properties;
    }

    public function __isset(string $name): bool
    {
        $getter = 'get' . ucfirst($name);
        return isset($this->_properties[$name]) || method_exists($this, $getter);
    }
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->_properties)) {
            return $this->_properties[$name];
        }

        if (method_exists($this, $getter = 'get' . ucfirst($name))) {
            return $this->$getter();
        }

        return null;
    }

    protected function getOriginProperty(string $name)
    {
        return array_key_exists($name, $this->_properties) ? $this->_properties[$name] : null;
    }

    public function __set(string $name, $value)
    {
        if (method_exists($this, $setter = 'set' . ucfirst($name))) {
            $this->$setter($value);
        } else {
            $this->_properties[$name] = $value;
        }
    }
}