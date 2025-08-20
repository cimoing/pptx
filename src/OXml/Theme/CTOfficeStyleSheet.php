<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property string $name
 * @property CTThemeElements $themeElements
 */
class CTOfficeStyleSheet extends BaseOXmlElement
{
    #[OneAndOnlyOne("a:themeElements")]
    protected CTThemeElements $_themeElements;

    #[RequiredAttribute("name", XsdString::class)]
    protected string $_name;
    public static function new_default()
    {

    }
}