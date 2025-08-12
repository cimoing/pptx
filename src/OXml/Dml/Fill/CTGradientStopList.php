<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneOrMore;

/**
 * @property CTGradientStop[] $gs_lst
 */
class CTGradientStopList extends BaseOXmlElement
{
    #[OneOrMore("a:gs")]
    protected array $_gs;

    public static function newGsLst(\DOMDocument $dom): static
    {
        $xml = sprintf('<a:gsLst %s>
    <a:gs pos="0">
        <a:schemeClr val="accent1">
            <a:tint val="100000"/>
            <a:shade val="100000"/>
            <a:satMod val="100000"/>
        </a:schemeClr>
    </a:gs>
    <a:gs pos="100000">
        <a:schemeClr val="accent1">
            <a:tint val="50000"/>
            <a:shade val="100000"/>
            <a:satMod val="350000"/>
        </a:schemeClr>
    </a:gs>
</a:gsLst>', nsdecls("a"));
        $obj = makeOXmlElement($dom, $xml);
        assert($obj instanceof static);
        return $obj;
    }
}