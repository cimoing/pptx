<?php

namespace Imoing\Pptx\Text\Text;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Color\Color;
use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Text\CTTextCharacterProperties;

/**
 * @property-read ColorFormat $color
 * @property-read FillFormat $fill
 * @property ?bool $bold
 */
class Font extends BaseObject
{
    private CTTextCharacterProperties $_element;
    private CTTextCharacterProperties $_rPr;
    public function __construct(CTTextCharacterProperties $rPr)
    {
        parent::__construct([]);
        $this->_element = $this->_rPr = $rPr;
    }

    public function getBold(): ?bool
    {
        return $this->_rPr->b;
    }

    public function setBold(?bool $value): void
    {
        $this->_rPr->b = $value;
    }

    private ?ColorFormat $_color = null;
    public function getColor(): ColorFormat
    {
        if (is_null($this->_color)) {
            if ($this->fill->type != MsoFillType::SOLID) {
                $this->fill->solid();
            }
            $this->_color = $this->fill->foreColor;
        }

        return $this->_color;
    }

    private ?FillFormat  $_fill = null;
    public function getFill(): FillFormat
    {
        if (!$this->_fill) {
            $this->_fill = FillFormat::fromFillParent($this->_rPr);
        }

        return $this->_fill;
    }
}