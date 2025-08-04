<?php

namespace Imoing\Pptx\OXml\Dml\Color;

use Imoing\Pptx\OXml\SimpleTypes\STPositiveFixedPercentage;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property float $r
 * @property float $g
 * @property float $b
 */
class CTScRgbColor extends BaseColorElement
{
    #[RequiredAttribute("r", STPositiveFixedPercentage::class)]
    protected float $_r;

    #[RequiredAttribute("g", STPositiveFixedPercentage::class)]
    protected float $_g;

    #[RequiredAttribute("b", STPositiveFixedPercentage::class)]
    protected float $_b;
}