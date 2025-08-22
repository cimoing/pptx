<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Dml\Fill\Fill;
use Imoing\Pptx\OXml\Slide\CTSlide;
use Imoing\Pptx\Shapes\Base\Theme;
use Imoing\Pptx\Shared\PartElementProxy;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

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
            $this->_background = new Background($this->_element->cSld, $this->theme);
        }
        return $this->_background;
    }

    public function getInheritedBackground(): Background
    {
        if (!$this->_element->cSld->bg) {
            $bg = $this->part->slideLayout->getInheritedBackground();
        } else {
            $bg = $this->getBackground();
        }

        return $bg;
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