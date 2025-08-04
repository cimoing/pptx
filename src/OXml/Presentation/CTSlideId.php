<?php

namespace Imoing\Pptx\OXml\Presentation;

use Imoing\Pptx\OXml\SimpleTypes\STSlideId;
use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * `p:sldId`元素
 * `p:sldIdLst``的直接子元素，包含指向slide的`rId`引用
 * @property string $rId
 */
class CTSlideId extends BaseOXmlElement
{
    #[RequiredAttribute("id",STSlideId::class)]
    public string $id;

    #[RequiredAttribute("r:id", XsdString::class)]
    protected string $_rId;
}