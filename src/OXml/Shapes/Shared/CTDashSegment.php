<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property Length $val
 */
class CTDashSegment extends BaseOXmlElement
{
    #[RequiredAttribute("val", Emu::class)]
    protected Length $_val;
}