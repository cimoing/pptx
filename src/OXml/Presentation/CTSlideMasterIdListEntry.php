<?php

namespace Imoing\Pptx\OXml\Presentation;

use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $rId
 */
class CTSlideMasterIdListEntry extends BaseOXmlElement
{
    #[RequiredAttribute("r:id", XsdString::class)]
    protected string $_rId;
}