<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\SimpleTypes\STTextSpacingPercentOrPercentString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

class CTTextSpacingPercent extends BaseOXmlElement
{
    #[RequiredAttribute("val", STTextSpacingPercentOrPercentString::class)]
    protected float $val;
}