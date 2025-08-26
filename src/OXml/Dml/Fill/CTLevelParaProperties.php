<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\Enum\PPParagraphAlignment;
use Imoing\Pptx\OXml\Text\CTTextCharacterProperties;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\Util\Length;

/**
 * @property ?PPParagraphAlignment $algn
 * @property ?Length $defTabSz
 * @property ?CTTextCharacterProperties $defRPr
 * @property ?BaseOXmlElement $buChar
 * @property ?BaseOXmlElement $buAutoNum
 */
class CTLevelParaProperties extends BaseOXmlElement
{
    #[OptionalAttribute("algn", PPParagraphAlignment::class, default: PPParagraphAlignment::LEFT)]
    protected string $_algn;

    #[OptionalAttribute("defTabSz", Length::class)]
    protected ?Length $_defTabSz;

    #[ZeroOrOne("a:defRPr", successors: ["a:extLst"])]
    protected ?CTTextCharacterProperties $_defRPr;

    #[ZeroOrOne("a:buChar")]
    protected mixed $_buChar;

    #[ZeroOrOne("a:buAutoNum")]
    protected mixed $_buAutoNum;
}