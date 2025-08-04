<?php

namespace Imoing\Pptx\Opc\OXml;

use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\SimpleTypes\STContentType;
use Imoing\Pptx\OXml\SimpleTypes\STExtension;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $extension
 * @property string $contentType
 */
class CTDefault extends BaseOXmlElement
{
    #[RequiredAttribute("Extension", STExtension::class)]
    protected string $extension;

    #[RequiredAttribute("ContentType", STContentType::class)]
    protected string $contentType;
}