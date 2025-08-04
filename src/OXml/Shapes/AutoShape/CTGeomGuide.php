<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $name
 * @property string $fmla
 */
class CTGeomGuide extends BaseOXmlElement
{
    #[RequiredAttribute("name", XsdString::class)]
    protected string $_name;

    #[RequiredAttribute("fmla", XsdString::class)]
    protected string $_fmla;
}