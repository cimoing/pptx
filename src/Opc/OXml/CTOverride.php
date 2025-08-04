<?php

namespace Imoing\Pptx\Opc\OXml;

use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\SimpleTypes\STContentType;
use Imoing\Pptx\OXml\SimpleTypes\XsdAnyUri;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $partName
 * @property string $contentType
 */
class CTOverride extends BaseOXmlElement
{
    #[RequiredAttribute("PartName", XsdAnyUri::class)]
    protected string $partName;

    #[RequiredAttribute("ContentType", STContentType::class)]
    protected string $contentType;
}