<?php

namespace Imoing\Pptx\Common;

/**
 * @property array $__arrayItems
 */
trait TraitArrayAccess
{
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->_properties);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->__arrayItems[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->__arrayItems[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->__arrayItems[$offset]);
    }
}