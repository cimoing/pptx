<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method CTTextCharacterProperties get_or_add_rPr()
 * @property ?CTTextCharacterProperties $rPr
 */
class CTTextLineBreak extends BaseOXmlElement
{
    #[ZeroOrOne("a:rPr")]
    protected string $_rPr;

    public function getText(): string
    {
        return "\v";
    }

    public function getHtmlText(): string
    {
        return $this->getText();
    }
}