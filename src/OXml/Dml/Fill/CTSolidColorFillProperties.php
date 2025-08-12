<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\Dml\Color\BaseColorElement;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

/**
 * @property BaseColorElement $eg_colorChoice
 */
class CTSolidColorFillProperties extends AbsFill
{
    #[ZeroOrOneChoice([
        new Choice("a:scrgbClr"),
        new Choice("a:srgbClr"),
        new Choice("a:hslClr"),
        new Choice("a:sysClr"),
        new Choice("a:schemeClr"),
        new Choice("a:prstClr"),
    ])]
    protected mixed $_eg_colorChoice;

    public function getJsonType(): string
    {
        return 'color';
    }
}