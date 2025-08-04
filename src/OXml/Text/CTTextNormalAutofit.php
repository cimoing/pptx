<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\SimpleTypes\STTextFontScalePercentOrPercentString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

class CTTextNormalAutofit extends BaseOXmlElement
{
    #[OptionalAttribute("fontScale", STTextFontScalePercentOrPercentString::class, default: 100.0)]
    protected float $fontScale;
}