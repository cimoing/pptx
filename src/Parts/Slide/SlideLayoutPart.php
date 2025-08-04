<?php

namespace Imoing\Pptx\Parts\Slide;

use Imoing\Pptx\Opc\Constants\RT;
use Imoing\Pptx\Slide\SlideLayout;
use Imoing\Pptx\Slide\SlideMaster;

/**
 * @property-read  SlideLayout $slideLayout
 * @property-read SlideMaster $slideMaster
 */
class SlideLayoutPart extends BaseSlidePart
{
    protected static string $nsTag = 'p:cSld';
    private ?SlideLayout $_slideLayout = null;
    public function getSlideLayout(): SlideLayout
    {
        if (null === $this->_slideLayout) {
            $this->_slideLayout = new SlideLayout($this->_element, $this);
        }
        return $this->_slideLayout;
    }

    private ?SlideMaster $_slideMaster = null;
    public function getSlideMaster(): SlideMaster
    {
        if (null === $this->_slideMaster) {
            $obj = $this->partRelatedBy(RT::SLIDE_MASTER);
            assert($obj instanceof SlideMasterPart);
            $this->_slideMaster = $obj->slideMaster;
        }
        return $this->slideMaster;
    }
}