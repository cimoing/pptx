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
}