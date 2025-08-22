<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $typeface
 * @property ?string $script
 */
class CTTextFont extends BaseOXmlElement
{
    #[RequiredAttribute("typeface", XsdString::class)]
    protected string $_typeface;

    #[OptionalAttribute("script", XsdString::class)]
    protected ?string $_script;
}