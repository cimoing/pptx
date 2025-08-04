<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\Util\Length;

/**
 * @property $height
 * @property $width
 * @property $left
 * @property MsoShapeType $shapeType
 * @property $top
 */
trait InheritsDimensions
{
    /**
     * @return Length
     */
    public function getHeight(): Length
    {
        return $this->getEffectiveValue("width");
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height): void
    {
        $this->_element->cx = $height;
    }

    /**
     * @return Length
     */
    public function getWidth(): Length
    {
        return $this->getEffectiveValue("width");
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width): void
    {
        $this->_element->cy = $width;
    }

    /**
     * @return Length
     */
    public function getLeft(): Length
    {
        return $this->getEffectiveValue("left");
    }

    /**
     * @param mixed $left
     */
    public function setLeft($left): void
    {
        $this->_element->x = $left;
    }

    /**
     * @return Length
     */
    public function getTop(): Length
    {
        return $this->getEffectiveValue("top");
    }

    /**
     * @param mixed $top
     */
    public function setTop($top): void
    {
        $this->_element->y = $top;
    }

    public function getShapeType(): MsoShapeType
    {
        return MsoShapeType::PLACEHOLDER;
    }


    abstract protected function getBasePlaceholder(): mixed;

    protected function getEffectiveValue(string $attrName)
    {
        $value = parent::__get($attrName);
        if ($value === null) {
            $value = $this->getInheritedValue($attrName);
        }

        return $value;
    }

    protected function getInheritedValue(string $attrName)
    {
        $basePh = $this->getBasePlaceholder();
        if (empty($basePh)) {
            return null;
        }

        return $basePh->$attrName;
    }
}