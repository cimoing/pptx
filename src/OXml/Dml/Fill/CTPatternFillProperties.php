<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\Enum\MsoPatternType;
use Imoing\Pptx\OXml\Dml\Color\CTColor;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;


/**
 * @property ?CTColor $fgClr
 * @property ?CTColor $bgClr
 * @property ?MsoPatternType $prst
 */
class CTPatternFillProperties extends BaseOXmlElement
{
    #[ZeroOrOne("a:fgClr", successors: ["a:bgClr"])]
    protected string $_fgClr;

    #[ZeroOrOne("a:bgClr", successors: [])]
    protected string $_bgClr;

    #[OptionalAttribute("prst", MsoPatternType::class)]
    protected string $_prst;

    protected function _new_bgClr(): BaseOXmlElement
    {
        $xml = sprintf("<a:bgClr %s>
        <a:srgbClr val=\"FFFFFF\"/>
        </a:bgClr>", nsdecls("a"));
        return makeOXmlElement($this->ownerDocument, $xml);
    }

    protected function _new_fgClr(): BaseOXmlElement
    {
        $xml = sprintf("<a:fgClr %s>
        <a:srgbClr val=\"000000\"/>
        </a:fgClr>", nsdecls("a"));
        return makeOXmlElement($this->ownerDocument, $xml);
    }
}