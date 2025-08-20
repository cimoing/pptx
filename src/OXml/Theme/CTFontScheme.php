<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property CTFonts $majorFont
 * @property CTFonts $minorFont
 */
class CTFontScheme extends BaseOXmlElement
{
    #[ZeroOrOne("a:majorFont")]
    protected CTFonts $_majorFont;

    #[ZeroOrOne("a:minorFont")]
    protected CTFonts $_minorFont;
}