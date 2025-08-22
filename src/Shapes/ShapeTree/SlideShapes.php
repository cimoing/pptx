<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Shapes\Base\Theme;
use Imoing\Pptx\Slide\Slide;
use Imoing\Pptx\Slide\SlideLayout;

/**
 * @property Slide $parent
 * @property-read  ?Shape $title
 * @property-read Theme $theme
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

    private ?LayoutPlaceholders $_layoutPlaceholders = null;
    public function getLayoutPlaceholders(): LayoutPlaceholders
    {
        if (is_null($this->_layoutPlaceholders)) {
            $this->_layoutPlaceholders = $this->parent->getLayoutPlaceholders();
        }

        return $this->_layoutPlaceholders;
    }
}