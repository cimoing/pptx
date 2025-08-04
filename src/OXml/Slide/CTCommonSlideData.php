<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * tag sequences: "p:bg", "p:spTree", "p:custDataLst", "p:controls", "p:extLst"
 * @method void _remove_bg()
 * @method CTBackground get_or_add_bg()
 * @property ?CTBackground $bg
 * @property CTGroupShape $spTree
 * @property string $name
 */
class CTCommonSlideData extends BaseOXmlElement
{
    #[ZeroOrOne("p:bg", successors: ["p:spTree", "p:custDataLst", "p:controls", "p:extLst"])]
    protected ?CTBackground $_bg;

    #[OneAndOnlyOne("p:spTree")]
    protected CTGroupShape $_spTree;

    #[OptionalAttribute("name", XsdString::class, default: "")]
    protected string $_name;
    public function get_or_add_bgPr(): CTBackgroundProperties
    {
        $bg = $this->bg;
        if (is_null($bg) || is_null($bg->bgPr)) {
            $bg = $this->changeToNoFillBg();
        }

        return $bg->bgPr;
    }
    protected function changeToNoFillBg(): CTBackground
    {
        $this->_remove_bg();
        $bg = $this->get_or_add_bg();
        $bg->add_noFill_bgPr();

        return $bg;
    }
}