<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\CTSolidColorFillProperties;

/**
 * @property ColorFormat $foreColor
 */
class SolidFill extends Fill
{
    protected CTSolidColorFillProperties $_solidFill;
    public function __construct($solidFill)
    {
        parent::__construct($solidFill);
        $this->_solidFill = $solidFill;
    }

    private ?ColorFormat $_foreColor = null;
    public function getForeColor(): ColorFormat
    {
        if ($this->_foreColor === null) {
            $this->_foreColor = ColorFormat::fromColorChoiceParent($this->_solidFill);
        }
        return $this->_foreColor;
    }

    public function getType(): ?MsoFillType
    {
        return MsoFillType::SOLID;
    }

    public function toArray(): array
    {
        $color = ColorFormat::fromColorChoiceParent($this->_solidFill);
        return $color->toArray();
    }
}