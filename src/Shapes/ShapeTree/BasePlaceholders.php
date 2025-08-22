<?php

namespace Imoing\Pptx\Shapes\ShapeTree;


use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\Shapes\Base\TextLevelParaStyle;

abstract class BasePlaceholders extends BaseShapes
{
    public static function isMemberElm(BaseShapeElement $shapeElement): bool
    {
        return $shapeElement->hasPhElm;
    }

    public function getTextLevelParaStyle(): TextLevelParaStyle
    {
        $items = TextLevelParaStyle::parseListStyle($this->_element->txBody?->lstStyle, $this->theme);

        return new TextLevelParaStyle($items);
    }
}