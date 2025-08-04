<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\Common\TraitArrayAccess;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\Placeholder\BaseSlidePlaceholder;
use Imoing\Pptx\Shared\ParentedElementProxy;
use Traversable;

/**
 * @property-read CTGroupShape $_element
 */
class SlidePlaceholders extends ParentedElementProxy implements \ArrayAccess, \IteratorAggregate, \Countable
{
    use TraitArrayAccess;

    /**
     * @return Traversable<int, Shape>
     * @throws \Exception
     */
    public function getIterator(): Traversable
    {
        $phElms = [];
        foreach ($this->_element->iter_ph_elms() as $phElm) {
            $phElms[$phElm->getPhIdx()] = $phElm;
        }

        ksort($phElms, SORT_ASC);

        return new \ArrayIterator(array_map(function ($elm) {
            return ShapeTree::slideShapeFactory($elm, $this);
        }, $phElms));
    }

    public function offsetGet($offset): Shape|BaseShape
    {
        foreach ($this->_element->iter_ph_elms() as $phElm) {
            if ($phElm->phIdx == $offset) {
                return ShapeTree::slideShapeFactory($phElm, $this);
            }
        }

        throw new \Exception("no placeholder on this slide with idx == {$offset}");
    }

    public function count(): int
    {
        return count(iterator_to_array($this->getIterator()));
    }
}