<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\OXml\Slide\CTCommonSlideData;
use Imoing\Pptx\Shared\ElementProxy;

/**
 * @property-read FillFormat $fill
 */
class Background extends ElementProxy
{
    protected CTCommonSlideData $_cSld;
    public function __construct(CTCommonSlideData $cSld)
    {
        parent::__construct($cSld);
        $this->_cSld = $cSld;
    }

    private ?FillFormat $_fill = null;
    public function getFill(): FillFormat
    {
        if (is_null($this->_fill)) {
            $bgPr = $this->_cSld->get_or_add_bgPr();
            $this->_fill = FillFormat::fromFillParent($bgPr);
        }

        return $this->_fill;
    }

    public function toArray(): array
    {
        return $this->getFill()->toArray();
    }
}