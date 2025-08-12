<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\Enum\MsoLanguageId;
use Imoing\Pptx\Enum\MsoTextStrikeType;
use Imoing\Pptx\Enum\MsoTextUnderlineType;
use Imoing\Pptx\OXml\Action\CTHyperlink;
use Imoing\Pptx\OXml\Dml\Fill\AbsFill;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientFillProperties;
use Imoing\Pptx\OXml\SimpleTypes\STTextFontSize;
use Imoing\Pptx\OXml\SimpleTypes\STTextSpacingPoint;
use Imoing\Pptx\OXml\SimpleTypes\XsdBoolean;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;
use Imoing\Pptx\Util\Centipoints;
use Imoing\Pptx\Util\Length;

/**
 * @method CTHyperlink get_or_add_hlinkClick()
 * @method CTTextFont get_or_add_latin()
 * @method void _remove_latin()
 * @method void _remove_hlinkClick()
 * @property ?AbsFill $eg_fillProperties
 * @property ?CTTextFont $latin
 * @property ?CTHyperlink $hyperClick
 * @property ?MsoLanguageId $lang
 * @property ?Length $sz 字体大小，单位：1/100磅 1磅=1/72英寸
 * @property ?Length $spc 字间距，单位：1/100磅 1磅=1/72英寸
 * @property ?bool $b
 * @property ?int $i
 * @property ?MsoTextUnderlineType $u
 * @property ?MsoTextStrikeType $strike
 * @property ?mixed $buChar
 * @property ?mixed $buFont
 * @property ?mixed $buAutoNum
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
    protected ?Length $_sz;

    #[OptionalAttribute("b", XsdBoolean::class)]
    protected ?bool $_b;

    #[OptionalAttribute("i", XsdBoolean::class)]
    protected ?bool $_i;

    #[OptionalAttribute("u", MsoTextUnderlineType::class)]
    protected ?MsoTextUnderlineType $_u;

    #[OptionalAttribute("spc", STTextSpacingPoint::class)]
    protected ?Length $_spc;

    #[OptionalAttribute("strike", MsoTextStrikeType::class)]
    protected ?MsoTextStrikeType $_strike;

    #[ZeroOrOne("a:buChar")]
    protected mixed $_buChar;

    #[ZeroOrOne("a:buFont")]
    protected mixed $_buFont;

    #[ZeroOrOne("a:buAutoNum")]
    protected mixed $_buAutoNum;

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

    public function toArray(): array
    {
        return array_filter([
            'wordSpace' => $this->spc ? $this->spc->px : null,
        ], function ($val) {
            return $val !== null;
        });
    }
}