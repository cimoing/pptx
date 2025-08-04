<?php

namespace Imoing\Pptx\OXml\Dml\Color;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

class CTColor extends BaseOXmlElement
{
    #[ZeroOrOneChoice([
        new Choice("a:scrgbClr"),
        new Choice("a:srgbClr"),
        new Choice("a:hslClr"),
        new Choice("a:sysClr"),
        new Choice("a:schemeClr"),
        new Choice("a:prstClr"),
    ], successors: [])]
    protected mixed $eg_colorChoice;
}