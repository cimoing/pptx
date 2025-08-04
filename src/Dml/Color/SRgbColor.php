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
        return RGBColor::fromString($this->_srgbClr->val);
    }

    public function setRgb(RGBColor $rgb): void
    {
        $this->_srgbClr->val = (string) $rgb;
    }

    public function __toString(): string
    {
        return $this->_srgbClr->val;
    }
}