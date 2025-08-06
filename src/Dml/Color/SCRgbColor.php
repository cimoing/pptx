<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\OXml\Dml\Color\CTScRgbColor;

/**
 * @property-read CTScRgbColor $_xClr
 */
class SCRgbColor extends Color
{
    public function getColorType(): ?MsoColorType
    {
        return MsoColorType::SCRGB;
    }

    public function getRgb(): RGBColor
    {
        return RGBColor::create(255 * $this->_xClr->r, 255 * $this->_xClr->g, 255 * $this->_xClr->b);
    }
}