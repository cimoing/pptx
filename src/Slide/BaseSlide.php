<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\OXml\Slide\CTSlide;
use Imoing\Pptx\Shared\PartElementProxy;

/**
 * @property-read CTSlide $_element
 * @property string $name
 */
class BaseSlide extends PartElementProxy
{
    private ?Background $_background = null;

    public function getBackground(): Background
    {
        if (is_null($this->_background)) {
            $this->_background = new Background($this->_element->cSld);
        }
        return $this->_background;
    }

    public function getInheritedBackground(): Background
    {
        if (!$this->_element->cSld->bg) {
            $bg = $this->part->slideLayout->getInheritedBackground();
        } else {
            $bg = $this->getBackground();
        }

        return $bg;
    }

    public function getName(): string
    {
        return $this->_element->cSld->name;
    }

    public function setName(?string $name): void
    {
        $newName = empty($name) ? "" : $name;
        $this->_element->cSld->name = $newName;
    }

    public static function calculateRotatePosition(array $offset, array $size, array $childOffset, int $rotate): array
    {
        $radians = $rotate * M_PI / 180;
        $centerX = $offset[0] + $size[0] / 2;
        $centerY = $offset[1] + $size[1] / 2;

        $relativeX = $childOffset[0] - $size[0] / 2;
        $relativeY = $childOffset[1] - $size[1] / 2;

        $rotateX = $relativeX * cos($radians) + $relativeY * sin($radians);
        $rotateY = $relativeX * -sin($radians) + $relativeY * cos($radians);
        $x = $centerX + $rotateX;
        $y = $centerY + $rotateY;
        return [$x, $y];
    }
}