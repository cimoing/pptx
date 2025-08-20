<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\Common\Point;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Slide\SlideLayout;

/**
 * @property-read SlideLayout $parent
 * @property-read float $globalRotation
 */
class LayoutShapes extends BaseShapes
{
    protected function shapeFactory(BaseShapeElement $shapeElement): BaseShape
    {
        return ShapeTree::layoutShapeFactory($shapeElement, $this);
    }

    public function getColorScheme(): array
    {
        return $this->parent->getColorScheme();
    }

    public function getSchemeColor(string $scheme): string
    {
        return $this->parent->getSchemeColor($scheme);
    }

    public function getGlobalRotation(): float
    {
        return $this->rotation;
    }
    public function getAbsRotation(): float
    {
        return $this->rotation;
    }

    public function getAbsOff(): array
    {
        return [$this->left, $this->top];
    }

    /**
     * 获取绝对偏移点
     * @return Point
     */
    public function getAbsOffsetPoint(): Point
    {
        return new Point($this->left->emu, $this->top->emu);
    }
}