<?php

namespace Imoing\Pptx\OXml\Dml\Color;

use Imoing\Pptx\OXml\SimpleTypes\STHexColorRGB;
use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

/**
 * @property ?string $lastClr
 * @property string $val
 */
class CTSystemColor extends BaseColorElement
{
    #[OptionalAttribute("val", XsdString::class)]
    protected string $_val;

    #[OptionalAttribute("lastClr", STHexColorRGB::class)]
    protected string $_lastClr;

    public function getHexValue(): string
    {
        return $this->lastClr ? sprintf('%s', $this->lastClr) : '';
    }
}