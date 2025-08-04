<?php

namespace Imoing\Pptx\Shapes\Placeholder;


use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\Parts\Slide\SlidePart;
use Imoing\Pptx\Shapes\AutoShape\Shape;

/**
 * @property-read bool $isPlaceholder
 * @property-read SlidePart $part
 */
class BaseSlidePlaceholder extends Shape
{
    use InheritsDimensions;

    public function getIsPlaceholder(): bool
    {
        return true;
    }

    public function getShapeType(): MsoShapeType
    {
        return MsoShapeType::PLACEHOLDER;
    }

    protected function getBasePlaceholder(): mixed
    {
        list($layout, $idx) = [$this->part->slideLayout, $this->_element->phIdx];
        return $layout->placeholders->get($idx);
    }

    protected function replacePlaceholderWith($element): void
    {
        $element->_nvXxPr->nvPr->_insert_ph($this->_element->ph);
        $this->_element->before($element);
        $this->_element->parentElement->removeChild($this->_element);
        $this->_element = null;
    }
}