<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\Shapes\Base\BaseShape;

class LayoutShapes extends BaseShapes
{
    protected function shapeFactory(BaseShapeElement $shapeElement): BaseShape
    {
        return ShapeTree::layoutShapeFactory($shapeElement, $this);
    }
}