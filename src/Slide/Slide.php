<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Parts\Slide\SlidePart;
use Imoing\Pptx\Shapes\ShapeTree\SlidePlaceholders;
use Imoing\Pptx\Shapes\ShapeTree\SlideShapes;

/**
 * @property SlidePart $part
 * @property-read bool $followMasterBackground
 * @property-read bool $hasNotesSlide
 * @property-read SlidePlaceholders $placeholders
 * @property SlideShapes $shapes
 */
class Slide extends BasesLide
{
    public function getFollowMasterBackground(): bool
    {
        return is_null($this->_element->bg);
    }

    public function getHasNotesSlide(): bool
    {
        //TODO
        return false;
    }

    private ?SlidePlaceholders $_placeholders = null;
    public function getPlaceholders(): SlidePlaceholders
    {
        if (is_null($this->_placeholders)) {
            $this->_placeholders = new SlidePlaceholders($this->_element->spTree, $this);
        }
        return $this->_placeholders;
    }

    private ?SlideShapes $_shapes = null;
    public function getShapes(): SlideShapes
    {
        if (is_null($this->_shapes)) {
            $this->_shapes = new SlideShapes($this->_element->spTree, $this);
        }

        return $this->_shapes;
    }

}