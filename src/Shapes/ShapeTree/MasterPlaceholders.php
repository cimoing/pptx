<?php

namespace Imoing\Pptx\Shapes\ShapeTree;


use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\Shapes\Placeholder\BasePlaceholder;
use Imoing\Pptx\Shapes\Placeholder\MasterPlaceholder;

class MasterPlaceholders extends BasePlaceholders implements \IteratorAggregate
{
    public function get(PPPlaceholderType $phType, ?MasterPlaceholder $default = null): ?MasterPlaceholder
    {
        foreach ($this as $placeholder) {
            if ($placeholder->phType === $phType) {
                return $placeholder;
            }
        }

        return $default;
    }

    protected function shapeFactory(BaseShapeElement|CTShape $shapeElement): MasterPlaceholder
    {
        $obj = ShapeTree::masterShapeFactory($shapeElement, $this);
        assert($obj instanceof MasterPlaceholder);
        return $obj;
    }
}