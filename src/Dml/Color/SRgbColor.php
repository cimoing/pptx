<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\OXml\Dml\Color\CTSRgbColor;

class SRgbColor extends Color
{
    /**
     * @var CTSRgbColor
     */
    protected CTSRgbColor $_srgbClr;
    public function __construct($srgbClr)
    {
        parent::__construct($srgbClr);
        $this->_srgbClr = $srgbClr;
    }
    public function getColorType(): ?MsoColorType
    {
        return MsoColorType::RGB;
    }

    public function getRgb(): RGBColor
    {
        $rgb = RGBColor::fromString($this->_srgbClr->val);
        if (!is_null($this->_srgbClr->alpha)) {
            $rgb->setAlpha(intval($this->_srgbClr->alpha?->val * 255));
        }

        return $rgb;
    }

    public function setRgb(RGBColor $rgb): void
    {
        $this->_srgbClr->val = (string) $rgb;
    }
}