<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\SimpleTypes\STTextTypeface;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $typeface
 */
class CTTextFont extends BaseOXmlElement
{
    #[RequiredAttribute("typeface", STTextTypeface::class)]
    protected string $typeface;
}