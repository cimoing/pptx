<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\OXml\Dml\Color\CTHslColor;

class HslColor extends Color
{
    private CTHslColor $_hslColor;
    public function __construct(CTHslColor $color)
    {
        parent::__construct($color);
        $this->_hslColor = $color;
    }

    public function getColorType(): ?MsoColorType
    {
        return MsoColorType::HSL;
    }

    public function getRgb(): RGBColor
    {
        return RGBColor::fromString($this->_hslColor->getHexValue());
    }
}