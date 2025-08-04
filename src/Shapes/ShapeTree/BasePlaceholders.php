<?php

namespace Imoing\Pptx\Shapes\ShapeTree;


use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;

abstract class BasePlaceholders extends BaseShapes
{
    public static function isMemberElm(BaseShapeElement $shapeElement): bool
    {
        return $shapeElement->hasPhElm;
    }
}