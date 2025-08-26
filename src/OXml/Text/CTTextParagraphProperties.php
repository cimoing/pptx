<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\Enum\PPParagraphAlignment;
use Imoing\Pptx\OXml\SimpleTypes\STTextIndentLevelType;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method  CTTextCharacterProperties get_or_add_defRPr()
 * @property ?CTTextCharacterProperties $defRPr
 * @property ?PPParagraphAlignment $algn
 * @property int $lvl
 * @property ?BaseOXmlElement $buChar
 * @property ?BaseOXmlElement $buAutoNum
 */
class CTTextParagraphProperties extends BaseOXmlElement
{
    #[ZeroOrOne("a:defRPr", successors: ["a:extLst"])]
    protected ?CTTextCharacterProperties $_defRPr;

    #[OptionalAttribute("lvl", STTextIndentLevelType::class, default: 0)]
    protected int $lvl;

    #[OptionalAttribute("algn", PPParagraphAlignment::class)]
    protected ?PPParagraphAlignment $_algn;

    #[ZeroOrOne("a:buChar")]
    protected mixed $_buChar;

    #[ZeroOrOne("a:buAutoNum")]
    protected mixed $_buAutoNum;
}