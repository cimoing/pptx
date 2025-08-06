<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\OXml\Slide\CTSlide;
use Imoing\Pptx\Shared\PartElementProxy;

/**
 * @property-read CTSlide $_element
 * @property string $name
 */
class BaseSlide extends PartElementProxy
{
    private ?Background $_background = null;

    public function getBackground(): Background
    {
        if (is_null($this->_background)) {
            $this->_background = new Background($this->_element->cSld);
        }
        return $this->_background;
    }

    public function getName(): string
    {
        return $this->_element->cSld->name;
    }

    public function setName(?string $name): void
    {
        $newName = empty($name) ? "" : $name;
        $this->_element->cSld->name = $newName;
    }
}