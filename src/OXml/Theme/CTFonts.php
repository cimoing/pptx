<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\Text\CTTextFont;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?CTTextFont $latin 拉丁字符字体
 * @property ?CTTextFont $ea 中日韩字符字体
 * @property ?CTTextFont $cs 复杂脚本字体
 * @property ?CTTextFont $font 通用字体
 */
class CTFonts extends BaseOXmlElement
{
    #[ZeroOrOne("a:latin")]
    protected ?CTTextFont $_latin;

    #[ZeroOrOne("a:ea")]
    protected ?CTTextFont $_ea;

    #[ZeroOrOne("a:cs")]
    protected ?CTTextFont $_cs;

    #[ZeroOrOne("a:font")]
    protected ?CTTextFont $_font;
}