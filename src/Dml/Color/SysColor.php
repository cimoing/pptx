<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\OXml\Dml\Color\CTSystemColor;

/**
 * @property-read CTSystemColor $_xClr
 */
class SysColor extends Color
{
    public function getColorType(): ?MsoColorType
    {
        return MsoColorType::SYSTEM;
    }

    public function getRgb(): RGBColor
    {
        return RGBColor::fromString($this->_xClr->getHexValue());
    }
}