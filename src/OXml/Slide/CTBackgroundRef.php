<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\Dml\Color\BaseColorElement;
use Imoing\Pptx\OXml\SimpleTypes\XsdUnsignedInt;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

/**
 * @property int $idx
 * @property BaseColorElement $eg_colorChoice
 */
class CTBackgroundRef extends BaseOXmlElement
{
    #[RequiredAttribute("idx", XsdUnsignedInt::class)]
    protected int $_idx;

    #[ZeroOrOneChoice([
        new Choice("a:scrgbClr"),
        new Choice("a:srgbClr"),
        new Choice("a:hslClr"),
        new Choice("a:sysClr"),
        new Choice("a:schemeClr"),
        new Choice("a:prstClr"),
    ])]
    protected mixed $_eg_colorChoice;
}