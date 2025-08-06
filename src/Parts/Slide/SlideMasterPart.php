<?php

namespace Imoing\Pptx\Parts\Slide;

use Imoing\Pptx\Opc\Constants\RT;
use Imoing\Pptx\Parts\Theme\OfficeStyleSheetPart;
use Imoing\Pptx\Slide\SlideLayout;
use Imoing\Pptx\Slide\SlideMaster;

/**
 * @property-read SlideMaster $slideMaster
 */
class SlideMasterPart extends BaseSlidePart
{
    protected static string $nsTag = 'p:sldMaster';
    public function getRelatedSlideLayout(string $rId): SlideLayout
    {
        $obj = $this->relatedPart($rId);
        assert($obj instanceof SlideLayoutPart);
        return $obj->slideLayout;
    }

    private ?SlideMaster $_slideMaster = null;
    public function getSlideMaster(): SlideMaster
    {
        if ($this->_slideMaster === null) {
            $this->_slideMaster = new SlideMaster($this->_element, $this);
        }
        return $this->_slideMaster;
    }

    public function getThemePart(): OfficeStyleSheetPart
    {
        $obj =  $this->partRelatedBy(RT::THEME);
        assert($obj instanceof OfficeStyleSheetPart);

        return $obj;
    }
}