<?php

namespace Imoing\Pptx\Dml\ChartFormat;

use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Dml\Line\LineFormat;
use Imoing\Pptx\Shared\ElementProxy;

/**
 * @property FillFormat $fill
 * @property LineFormat $line
 */
class ChartFormat extends ElementProxy
{
    private ?FillFormat $_fill = null;
    public function getFill(): FillFormat
    {
        if ($this->_fill === null) {
            $spPr = $this->_element->get_or_add_spPr();
            $this->_fill = FillFormat::fromFillParent($spPr);
        }

        return $this->_fill;
    }

    private ?LineFormat $_line = null;
    public function getLine(): ?LineFormat
    {
        if ($this->_line === null) {
            $spPr = $this->_element->get_or_add_spPr();
            $this->_line = new LineFormat($spPr);
        }

        return $this->_line;
    }
}