<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;

/**
 * @property CTColorScheme $clrScheme
 * @property CTFontScheme $fontScheme
 * @property CTFormatScheme $fmtScheme
 */
class CTThemeElements extends BaseOXmlElement
{
    #[OneAndOnlyOne("a:clrScheme")]
    protected CTColorScheme $_clrScheme;

    #[OneAndOnlyOne("a:fontScheme")]
    protected CTFontScheme $_fontScheme;

    #[OneAndOnlyOne("a:fmtScheme")]
    protected CTFormatScheme $_fmtScheme;
}