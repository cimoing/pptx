<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * tag sequences "p:cSld", "p:clrMapOvr", "p:transition", "p:timing", "p:extLst"
 * @property CTCommonSlideData $cSld
 * @property ?CTBackground $bg
 */
class CTSlide extends BaseSlideElement
{
    #[OneAndOnlyOne("p:cSld")]
    protected CTCommonSlideData $_cSld;

    #[ZeroOrOne("p:clrMapOvr", successors: ["p:transition", "p:timing", "p:extLst"])]
    protected mixed $_clrMapOvr;

    #[ZeroOrOne("p:timing", successors: ["p:extLst"])]
    protected mixed $_timing;

    public static function create(): static
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $xml = self::getSldXml();
        $dom->loadXML($xml);
        $obj = NsMap::castDom($dom->documentElement);
        assert($obj instanceof static);
        return $obj;
    }

    public function getBg(): ?CTBackground
    {
        return $this->cSld->bg;
    }

    public function get_or_add_childTnLst()
    {
        $childTnLst = $this->getChildTnLst();
        if (is_null($childTnLst)) {
            $childTnLst = $this->_add_childTnLst();
        }

        return $childTnLst;
    }

    protected function _add_childTnLst()
    {
        $this->removeChild($this->get_or_add_timing());
        $timing = makeOXmlElement($this->ownerDocument, self::getChildTnLstTimingXml());

        $this->_insert_timing($timing);

        return $timing->getElementsByNsTagName("p:childTnLst")->item(0);
    }

    protected function getChildTnLst()
    {
        $children = $this->getElementsByNsTagName('p:childTnLst');
        if ($children->count() == 0) {
            return null;
        }

        return $children->item(0);
    }

    private static function getChildTnLstTimingXml(): string
    {
        return sprintf(
        "<p:timing %s>".
              "<p:tnLst>".
                "<p:par>".
                  "<p:cTn id=\"1\" dur=\"indefinite\" restart=\"never\" nodeType=\"tmRoot\">".
                    "<p:childTnLst/>".
                  "</p:cTn>".
                "</p:par>".
              "</p:tnLst>".
            "</p:timing>", nsdecls("p")
        );
    }

    private static function getSldXml(): string
    {
        return sprintf(
        "<p:sld %s><p:cSld><p:spTree><p:nvGrpSpPr><p:cNvPr id=\"1\" name=\"\"/>".
        "<p:cNvGrpSpPr/><p:nvPr/></p:nvGrpSpPr><p:grpSpPr/></p:spTree></p:cSld><p:clrMapOvr>".
        "<a:masterClrMapping/></p:clrMapOvr></p:sld>",
        nsdecls(["a", "p", "r"])
        );
    }
}