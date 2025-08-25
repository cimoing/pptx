<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\CTSolidColorFillProperties;
use Imoing\Pptx\Shapes\Base\Theme;

/**
 * @property ColorFormat $foreColor
 */
class SolidFill extends Fill
{
    protected CTSolidColorFillProperties $_solidFill;
    public function __construct($solidFill, ?Theme $theme = null)
    {
        parent::__construct($solidFill, $theme);
        $this->_solidFill = $solidFill;
    }

    private ?ColorFormat $_foreColor = null;
    public function getForeColor(): ColorFormat
    {
        if ($this->_foreColor === null) {
            if ($this->_solidFill->eg_colorChoice?->isPlaceholderColor()) {
                $this->_foreColor = ColorFormat::fromColorChoice($this->_phClrLst[0], $this->_theme);
            } else {
                $this->_foreColor = ColorFormat::fromColorChoiceParent($this->_solidFill, $this->_theme);
            }
        }
        return $this->_foreColor;
    }

    public function getType(): ?MsoFillType
    {
        return MsoFillType::SOLID;
    }

    public function toArray(): array
    {
        $clr = $this->getForeColor();
        return $clr->toArray();
    }
}