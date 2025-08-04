<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method CTTextCharacterProperties get_or_add_rPr()
 */
class CTTextField extends BaseOXmlElement
{
    #[ZeroOrOne("a:rPr", successors: ["a:pPr", "a:t"])]
    protected ?CTTextCharacterProperties $rPr;

    #[ZeroOrOne("a:t", successors: [])]
    protected ?BaseOXmlElement $t;

    public function getText(): string
    {
        $t = $this->__get('t');
        if (empty($t)) {
            return "";
        }

        return $t->textContent ?: '';
    }
}