<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property CTFillStyleList $fillStyleLst
 * @property CTFillStyleList $bgFillStyleLst
 */
class CTFormatScheme extends BaseOXmlElement
{
    #[ZeroOrOne("a:fillStyleLst")]
    protected CTFillStyleList $_fillStyleLst;

    #[ZeroOrOne("a:bgFillStyleLst")]
    protected CTFillStyleList $_bgFillStyleLst;

    #[RequiredAttribute("name", XsdString::class)]
    protected string $_name;
}