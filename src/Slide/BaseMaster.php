<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Shapes\ShapeTree\MasterPlaceholders;
use Imoing\Pptx\Shapes\ShapeTree\MasterShapes;

/**
 * @property-read MasterPlaceholders $placeholders
 * @property-read MasterShapes $shapes
 */
class BaseMaster extends BasesLide
{
    private ?MasterPlaceholders $_placeholders = null;
    public function getPlaceholders(): MasterPlaceholders
    {
        if (null === $this->_placeholders) {
            $this->_placeholders = new MasterPlaceholders($this->_element->spTree, $this);
        }

        return $this->_placeholders;
    }

    private ?MasterShapes $_shapes = null;
    public function getShapes(): MasterShapes
    {
        if (null === $this->_shapes) {
            $this->_shapes = new MasterShapes($this->_element->spTree, $this);
        }
        return $this->_shapes;
    }

}