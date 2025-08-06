<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2D;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method CTGradientStopList get_or_add_gsLst()
 * @property ?CTGradientStopList $gsLst
 * @property ?CTLinearShadeProperties $lin
 * @property ?CTPath2D $path
 */
class CTGradientFillProperties extends AbsFill
{
    #[ZeroOrOne("a:gsLst", successors: ["a:lin", "a:path", "a:tileRect"])]
    protected ?CTGradientStopList $_gsLst;

    #[ZeroOrOne("a:lin", successors: ["a:path", "a:tileRect"])]
    protected ?CTLinearShadeProperties $_lin;

    #[ZeroOrOne("a:path", successors: ["a:tileRect"])]
    protected ?CTPath2D $_path;

    public static function newGradFill(\DOMDocument $dom): static
    {
        $xml = sprintf('<a:gradFill %s rotWithShape="1">
    <a:gsLst>
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
        </a:gs>>
    </a:gsLst>
    <a:lin scaled="0"/>
</a:gradFill>', nsdecls("a"));

        $obj =  makeOXmlElement($dom, $xml);
        assert($obj instanceof static);
        return $obj;
    }

    public function _new_gsLst(): CTGradientStopList
    {
        return CTGradientStopList::newGsLst($this->ownerDocument);
    }

    public function getJsonType(): string
    {
        return 'gradient';
    }
}