<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\Text\CTTextFont;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

/**
 * @property ?CTTextFont $latin 拉丁字符字体
 * @property ?CTTextFont $ea 中日韩字符字体
 * @property ?CTTextFont $cs 复杂脚本字体
 * @property CTTextFont[] $font_lst 通用字体
 */
class CTFonts extends BaseOXmlElement
{
    #[ZeroOrOne("a:latin")]
    protected ?CTTextFont $_latin;

    #[ZeroOrOneChoice([
        new Choice("a:ea"),
        new Choice("a:eastAsian"),

    ])]
    protected ?CTTextFont $_ea;

    #[ZeroOrOneChoice([
        new Choice("a:cs"),
        new Choice("a:complexScript"),
    ])]
    protected ?CTTextFont $_cs;

    #[ZeroOrMore("a:font")]
    protected array $_font;
}