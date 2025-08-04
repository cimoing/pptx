<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\SimpleTypes\STTextSpacingPoint;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\Util\Length;

class CTTextSpacingPoint extends BaseOXmlElement
{
    #[RequiredAttribute("val", STTextSpacingPoint::class)]
    protected Length $val;
}