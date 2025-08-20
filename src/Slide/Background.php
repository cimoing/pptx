<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\OXml\Dml\Fill\CTNoFillProperties;
use Imoing\Pptx\OXml\Slide\CTBackgroundRef;
use Imoing\Pptx\OXml\Slide\CTCommonSlideData;
use Imoing\Pptx\Shared\ElementProxy;

/**
 * @property-read FillFormat $fill
 */
class Background extends ElementProxy
{
    protected ?CTCommonSlideData $_cSld;
    public function __construct(?CTCommonSlideData $cSld)
    {
        parent::__construct($cSld);
        $this->_cSld = $cSld;
    }

    public static function createFromFill(FillFormat $fill): static
    {
        $obj = new static(null);
        $obj->_fill = $fill;
        return $obj;
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

    /**
     * 是否有背景
     * @return bool
     */
    public function hasBg(): bool
    {
        return (!is_null($this->_cSld?->bg) && !($this->_cSld?->bg->bgPr->eg_fillProperties instanceof CTNoFillProperties)) || !is_null($this->_fill);
    }

    /**
     * 是否为引用背景
     * @return bool
     */
    public function hasBgRef(): bool
    {
        return !is_null($this->_cSld?->bg) && !is_null($this->_cSld?->bg->bgRef);
    }

    public function getBgRef(): CTBackgroundRef
    {
        return $this->_cSld?->bg?->bgRef;
    }

    public function toArray(): array
    {
        return $this->getFill()->toArray();
    }
}