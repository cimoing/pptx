<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\Dml\Color\BaseColorElement;
use Imoing\Pptx\OXml\SimpleTypes\STPositiveFixedPercentage;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

/**
 * @property float $pos
 * @property ?BaseColorElement $eg_colorChoice
 */
class CTGradientStop extends BaseOXmlElement
{
    #[ZeroOrOneChoice([
        new Choice("a:scrgbClr"),
        new Choice("a:srgbClr"),
        new Choice("a:hslClr"),
        new Choice("a:sysClr"),
        new Choice("a:schemeClr"),
        new Choice("a:prstClr"),
    ], successors: [])]
    protected $_eg_colorChoice;

    #[RequiredAttribute("pos", STPositiveFixedPercentage::class)]
    protected float $_pos;
}