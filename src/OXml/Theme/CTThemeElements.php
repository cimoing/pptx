<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;

/**
 * @property CTColorScheme $clrScheme
 */
class CTThemeElements extends BaseOXmlElement
{
    #[OneAndOnlyOne("a:clrScheme")]
    protected mixed $_clrScheme;
}