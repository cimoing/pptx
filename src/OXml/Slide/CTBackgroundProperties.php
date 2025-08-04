<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\Dml\Fill\AbsFill;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientFillProperties;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

/**
 * tag sequences: "a:noFill","a:solidFill","a:gradFill","a:blipFill","a:pattFill","a:grpFill","a:effectLst","a:effectDag","a:extLst",
 * @property ?AbsFill $eg_fillProperties
 */
class CTBackgroundProperties extends BaseOXmlElement
{
    #[ZeroOrOneChoice([
        new Choice("a:noFill"),
        new Choice("a:solidFill"),
        new Choice("a:gradFill"),
        new Choice("a:blipFill"),
        new Choice("a:pattFill"),
        new Choice("a:grpFill")
    ], successors: ["a:effectLst", "a:effectDag", "a:extLst",])]
    protected string $_eg_fillProperties;

    protected function _new_gradFill(): CTGradientFillProperties
    {
        return CTGradientFillProperties::newGradFill($this->ownerDocument);
    }
}