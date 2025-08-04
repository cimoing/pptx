<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

class CTSolidColorFillProperties extends BaseOXmlElement
{
    #[ZeroOrOneChoice([
        new Choice("a:scrgbClr"),
        new Choice("a:srgbClr"),
        new Choice("a:hslClr"),
        new Choice("a:sysClr"),
        new Choice("a:schemeClr"),
        new Choice("a:prstClr"),
    ])]
    protected string $eg_colorChoice;
}