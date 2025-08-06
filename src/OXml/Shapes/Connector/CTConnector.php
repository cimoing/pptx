<?php

namespace Imoing\Pptx\OXml\Shapes\Connector;

use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\OXml\Shapes\Shared\CTShapeProperties;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;

/**
 * tag sequences: "p:nvCxnSpPr", "p:spPr", "p:style", "p:extLst"
 * @property mixed $nvCxnSpPr
 * @property CTShapeProperties $spPr
 */
class CTConnector extends BaseShapeElement
{
    #[OneAndOnlyOne("p:nvCxnSpPr")]
    protected mixed $_nvCxnSpPr;

    #[OneAndOnlyOne("p:spPr")]
    protected CTShapeProperties $_spPr;

    public static function createCxnSp(\DOMDocument $dom, int $id, string $name, string $prst, int $x, int $y, int $cx, int $cy, bool $flipH, bool $flipV): CTConnector
    {
        $flip = ($flipH ? ' flipH="1"' : '') . (($flipV ? ' flipV="1"' : ''));
        $xml = sprintf(
            "<p:cxnSp %s>\n".
                "  <p:nvCxnSpPr>\n".
                "    <p:cNvPr id=\"{$id}\" name=\"{$name}\"/>\n".
                "    <p:cNvCxnSpPr/>\n".
                "    <p:nvPr/>\n".
                "  </p:nvCxnSpPr>\n".
                "  <p:spPr>\n".
                "    <a:xfrm{$flip}>\n".
                "      <a:off x=\"{$x}\" y=\"{$y}\"/>\n".
                "      <a:ext cx=\"{$cx}\" cy=\"{$cy}\"/>\n".
                "    </a:xfrm>\n".
                "    <a:prstGeom prst=\"{$prst}\">\n".
                "      <a:avLst/>\n".
                "    </a:prstGeom>\n".
                "  </p:spPr>\n".
                "  <p:style>\n".
                '    <a:lnRef idx="2">'.
                '      <a:schemeClr val="accent1"/>'.
                "    </a:lnRef>\n".
                '    <a:fillRef idx="0">'.
                '      <a:schemeClr val="accent1"/>'.
                "    </a:fillRef>\n".
                '    <a:effectRef idx="1">'.
                '      <a:schemeClr val="accent1"/>'.
                "    </a:effectRef>\n".
                '    <a:fontRef idx="minor">'.
                '      <a:schemeClr val="tx1"/>'.
                "    </a:fontRef>\n".
                "  </p:style>\n".
                "</p:cxnSp>", nsdecls(['a', 'p']));

        $obj = makeOXmlElement($dom, $xml);
        assert($obj instanceof CTConnector);

        return $obj;
    }

}