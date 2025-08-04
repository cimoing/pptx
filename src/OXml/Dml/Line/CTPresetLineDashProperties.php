<?php

namespace Imoing\Pptx\OXml\Dml\Line;

use Imoing\Pptx\Enum\MsoLineDashStyle;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

/**
 * @property MsoLineDashStyle $val
 */
class CTPresetLineDashProperties extends BaseOXmlElement
{
    #[OptionalAttribute("val", MsoLineDashStyle::class)]
    protected string $_val;
}