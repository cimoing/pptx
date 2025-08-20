<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\Common\Point;
use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Slide\Slide;
use Imoing\Pptx\Slide\SlideLayout;
use Imoing\Pptx\Slide\SlideLayouts;
use Imoing\Pptx\Util\Length;

/**
 * @property Slide $parent
 * @property-read  ?Shape $title
 */
class SlideShapes extends BaseGroupShapes
{
    public function cloneLayoutPlaceholders(SlideLayout $slideLayout): void
    {
        foreach ($slideLayout->iterClonablePlaceholders() as $placeholder) {
            $this->clonePlaceholder($placeholder);
        }
    }
    public function getTitle(): ?Shape
    {
        foreach ($this->_spTree->iter_shape_elms() as $elm) {
            if ($elm->phIdx === 0) {
                $obj = $this->shapeFactory($elm);
                assert($obj instanceof Shape);
                return $obj;
            }
        }

        return null;
    }

    public function getColorScheme(): array
    {
        return $this->parent->getColorScheme();
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