<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Slide\SlideLayout;

/**
 * @property-read SlideLayout $parent
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
}