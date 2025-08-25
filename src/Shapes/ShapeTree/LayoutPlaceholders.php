<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\Placeholder\LayoutPlaceholder;

/**
 * @method \Traversable<int,LayoutPlaceholder> getIterator()
 */
class LayoutPlaceholders extends BasePlaceholders implements \IteratorAggregate
{
    public function get(int $idx, ?LayoutPlaceholder $default = null): ?LayoutPlaceholder
    {
        foreach ($this as $placeholder) {
            if ($placeholder->element->phIdx == $idx) {
                return $placeholder;
            }
        }

        return $default;
    }

    public function getByType(PPPlaceholderType $type, ?LayoutPlaceholder $default = null): ?LayoutPlaceholder
    {
        foreach ($this as $placeholder) {
            /**
             * @var LayoutPlaceholder $placeholder
             */
            if ($placeholder->element->phType == $type) {
                return $placeholder;
            }
        }

        return $default;
    }

    protected function shapeFactory(BaseShapeElement $shapeElement): BaseShape
    {
        return ShapeTree::layoutShapeFactory($shapeElement, $this);
    }
}