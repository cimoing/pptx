<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\Shapes\ShapeTree\MasterPlaceholders;
use Imoing\Pptx\Shapes\ShapeTree\MasterShapes;

/**
 * @property-read MasterPlaceholders $placeholders
 * @property-read MasterShapes $shapes
 */
class BaseMaster extends BaseSlide
{
    private ?MasterPlaceholders $_placeholders = null;
    public function getPlaceholders(): MasterPlaceholders
    {
        if (null === $this->_placeholders) {
            $this->_placeholders = new MasterPlaceholders($this->_element->cSld->spTree, $this);
        }

        return $this->_placeholders;
    }

    public function getPhLevelPPr(PPPlaceholderType $phType, int $level): ?CTLevelParaProperties
    {
        $ph = $this->placeholders->get($phType);
        if (!$ph) {
            return null;
        }

        return $ph->getLevelPPr($level);
    }

    private ?MasterShapes $_shapes = null;
    public function getShapes(): MasterShapes
    {
        if (null === $this->_shapes) {
            $this->_shapes = new MasterShapes($this->_element->cSld->spTree, $this);
        }
        return $this->_shapes;
    }

}