<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\Dml\Color\CTSchemeColor;
use Imoing\Pptx\OXml\SimpleTypes\XsdUnsignedInt;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @property int $idx
 * @property CTSchemeColor[] $schemeClr_lst
 */
class CTBackgroundRef extends BaseOXmlElement
{
    #[RequiredAttribute("idx", XsdUnsignedInt::class)]
    protected int $_idx;

    #[ZeroOrMore("a:schemeClr")]
    protected array $_schemeClr;
}