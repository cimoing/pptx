<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\OXml\Slide\CTSlideMaster;

/**
 * @property CTSlideMaster $_element
 * @property-read SlideLayouts $slideLayouts
 */
class SlideMaster extends BaseMaster
{
    private ?SlideLayouts $_layouts = null;
    public function getSlideLayouts(): SlideLayouts
    {
        if (null === $this->_layouts) {
            $this->_layouts = new SlideLayouts($this->_element->get_or_add_sldLayoutIdLst(), $this);
        }
        return $this->_layouts;
    }
}