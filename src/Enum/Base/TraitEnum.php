<?php

namespace Imoing\Pptx\Enum\Base;

/**
 * @method static array getDescriptions()
 */
trait TraitEnum
{
    public function getDescription(): string
    {
        return static::getDescriptions()[$this->value] ?? '';
    }
}
