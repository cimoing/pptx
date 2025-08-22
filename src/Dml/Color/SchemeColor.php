<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\Enum\MsoThemeColorIndex;
use Imoing\Pptx\OXml\Dml\Color\CTSchemeColor;
use Imoing\Pptx\Shapes\Base\Theme;

class SchemeColor extends Color
{
    /**
     * @var CTSchemeColor
     */
    protected mixed $_schemeClr;
    public function __construct($schemeClr, ?Theme $theme)
    {
        parent::__construct($schemeClr, $theme);
        $this->_schemeClr = $schemeClr;
    }
    public function getColorType(): ?MsoColorType
    {
        return MsoColorType::SCHEME;
    }

    public function getThemeColor(): MsoThemeColorIndex
    {
        return $this->_schemeClr->val;
    }

    public function setThemeColor(MsoThemeColorIndex $color): void
    {
        $this->_schemeClr->val = $color;
    }

    public function getRgb(): RGBColor
    {
        $hex = $this->_theme->getSchemeColor($this->_schemeClr->val->getXmlValue());

        return RGBColor::fromString($hex);
    }

    public function __toString(): string
    {
        return $this->_schemeClr->val->getXmlValue();
    }
}