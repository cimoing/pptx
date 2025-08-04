<?php

namespace Imoing\Pptx\OXml\Dml\Color;

use Imoing\Pptx\OXml\SimpleTypes\STPercentage;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property float $val
 */
class CTPercentage extends BaseOXmlElement
{
    #[RequiredAttribute("val", STPercentage::class)]
    protected float $_val;
}