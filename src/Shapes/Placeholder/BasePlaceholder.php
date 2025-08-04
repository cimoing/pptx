<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\Shapes\AutoShape\Shape;

/**
 * @property-read int $idx
 * @property-read string $orient
 * @property-read MsoShapeType $phType
 * @property-read string $sz
 */
class BasePlaceholder extends Shape
{
    public function getIdx(): int
    {
        return $this->_sp->phIdx;
    }

    public function getOrient(): string
    {
        return $this->_sp->phOrient;
    }

    public function getPhType(): PPPlaceholderType
    {
        return $this->_sp->phType;
    }

    public function getSz(): string
    {
        return $this->_sp->phSz;
    }

}