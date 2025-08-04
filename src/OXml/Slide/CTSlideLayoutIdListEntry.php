<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $rId
 */
class CTSlideLayoutIdListEntry extends BaseOXmlElement
{
    #[RequiredAttribute("r:id", XsdString::class)]
    protected string $rId;
}