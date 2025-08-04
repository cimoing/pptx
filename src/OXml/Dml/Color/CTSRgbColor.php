<?php

namespace Imoing\Pptx\OXml\Dml\Color;

use Imoing\Pptx\OXml\SimpleTypes\STHexColorRGB;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $val
 */
class CTSRgbColor extends BaseColorElement
{
    #[RequiredAttribute("val", STHexColorRGB::class)]
    protected mixed $_val;
}