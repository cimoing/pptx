<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\Enum\MsoFillType;

/**
 * @property ColorFormat $foreColor
 */
class SolidFill extends Fill
{
    protected mixed $_solidFill;
    public function __construct($solidFill)
    {
        parent::__construct();
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
        return [
            'type' => 'color',
            'value' => sprintf('#%s', $this->foreColor->getRgb()),
        ];
    }
}