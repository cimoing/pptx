<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\Enum\MsoLanguageId;
use Imoing\Pptx\Enum\MsoTextUnderlineType;
use Imoing\Pptx\OXml\Action\CTHyperlink;
use Imoing\Pptx\OXml\Dml\Fill\AbsFill;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientFillProperties;
use Imoing\Pptx\OXml\SimpleTypes\STTextFontSize;
use Imoing\Pptx\OXml\SimpleTypes\XsdBoolean;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

/**
 * @method CTHyperlink get_or_add_hlinkClick()
 * @method CTTextFont get_or_add_latin()
 * @method void _remove_latin()
 * @method void _remove_hlinkClick()
 * @property ?AbsFill $eg_fillProperties
 * @property ?CTTextFont $latin
 * @property ?CTHyperlink $hyperClick
 * @property ?MsoLanguageId $lang
 * @property ?int $sz
 * @property ?bool $b
 * @property ?int $i
 * @property ?MsoTextUnderlineType $u
 */
class CTTextCharacterProperties extends BaseOXmlElement
{
    #[ZeroOrOneChoice([
        new Choice("a:noFill"),
        new Choice("a:solidFill"),
        new Choice("a:gradFill"),
        new Choice("a:blipFill"),
        new Choice("a:pattFill"),
        new Choice("a:grpFill"),
    ], successors: [
        "a:effectLst",
        "a:effectDag",
        "a:highlight",
        "a:uLnTx",
        "a:uLn",
        "a:uFillTx",
        "a:uFill",
        "a:latin",
        "a:ea",
        "a:cs",
        "a:sym",
        "a:hlinkClick",
        "a:hlinkMouseOver",
        "a:rtl",
        "a:extLst",
    ])]
    protected ?AbsFill $_eg_fillProperties;

    #[ZeroOrOne("a:latin", successors: [
        "a:ea",
        "a:cs",
        "a:sym",
        "a:hlinkClick",
        "a:hlinkMouseOver",
        "a:rtl",
        "a:extLst",
    ])]
    protected ?CTTextFont $_latin;

    #[ZeroOrOne("a:hlinkClick", successors: ["a:hlinkMouseOver", "a:rtl", "a:extLst"])]
    protected ?CTHyperlink $_hyperClick;

    #[OptionalAttribute("lang", MsoLanguageId::class)]
    protected ?MsoLanguageId $_lang;

    #[OptionalAttribute("sz", STTextFontSize::class)]
    protected ?int $_sz;

    #[OptionalAttribute("b", XsdBoolean::class)]
    protected ?bool $_b;

    #[OptionalAttribute("i", XsdBoolean::class)]
    protected ?bool $_i;

    #[OptionalAttribute("u", MsoTextUnderlineType::class)]
    protected ?MsoTextUnderlineType $_u;

    protected function _new_gradFill(): CTGradientFillProperties
    {
        return CTGradientFillProperties::newGradFill($this->ownerDocument);
    }

    public function add_hlinkClick(string $rId): CTHyperlink
    {
        $hlinkClick = $this->get_or_add_hlinkClick();
        $hlinkClick->rId = $rId;

        return $hlinkClick;
    }
}