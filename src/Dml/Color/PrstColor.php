<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\OXml\Dml\Color\CTPresetColor;

/**
 * @property-read CTPresetColor $_xClr
 */
class PrstColor extends Color
{
    public function getColorType(): ?MsoColorType
    {
        return MsoColorType::PRESET;
    }

    public function getRgb(): RGBColor
    {
        return RGBColor::fromString($this->_xClr->getHexValue());
    }
}