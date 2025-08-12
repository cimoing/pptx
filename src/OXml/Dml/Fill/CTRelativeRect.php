<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\SimpleTypes\STPercentage;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

/**
 * @property ?float $l
 * @property ?float $t
 * @property ?float $r
 * @property ?float $b
 */
class CTRelativeRect extends BaseOXmlElement
{
    #[OptionalAttribute("l", STPercentage::class, default: 0.0)]
    protected ?float $_l;

    #[OptionalAttribute("t", STPercentage::class, default: 0.0)]
    protected ?float $_t;

    #[OptionalAttribute("r", STPercentage::class, default: 0.0)]
    protected ?float $_r;

    #[OptionalAttribute("b", STPercentage::class, default: 0.0)]
    protected ?float $_b;
}