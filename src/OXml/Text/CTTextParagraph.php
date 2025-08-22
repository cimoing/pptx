<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method CTTextCharacterProperties get_or_add_endParaRPr()
 * @method CTTextParagraphProperties get_or_add_pPr()
 * @method CTTextLineBreak _add_br()
 * @method CTRegularTextRun _add_r()
 * @property-read CTRegularTextRun[]|CTTextLineBreak[]|CTTextField[] $contentChildren
 * @property ?CTTextParagraphProperties $pPr
 * @property CTRegularTextRun[] $r_lst
 * @property ?CTTextCharacterProperties $endParaRPr
 */
class CTTextParagraph extends BaseOXmlElement
{
    #[ZeroOrOne("a:pPr", successors: ["a:r", "a:br", "a:fld", "a:endParaRPr"])]
    protected ?CTTextParagraphProperties $_pPr;

    #[ZeroOrMore("a:r", successors: ["a:endParaRPr",])]
    protected string $_r;

    #[ZeroOrMore("b:br", successors: ["a:endParaRPr"])]
    protected string $_br;

    #[ZeroOrOne("a:endParaRPr", successors: [])]
    protected ?CTTextCharacterProperties $_endParaRPr;

    public function addBr(): CTTextLineBreak
    {
        return $this->_add_br();
    }

    public function addR(?string $text = null): CTRegularTextRun
    {
        $r = $this->_add_r();
        if (!empty($text)) {
            $r->setText($text);
        }

        return $r;
    }

    public function append_text(string $text): void
    {
        $items = preg_split('/\n|\v/', $text);
        foreach ($items as $idx => $item) {
            if ($idx > 0) {
                $this->addBr();
            }
            if (!empty($item)) {
                $this->addR($item);
            }
        }
    }

    /**
     * @return BaseOXmlElement[]
     */
    public function getContentChildren(): array
    {
        $result = [];
        foreach ($this->childNodes as $node) {
            if ($node instanceof \DOMElement && in_array($node->tagName, ["a:r", "a:br", "a:fld"])) {
                $result[] = NsMap::castDom($node);
            }
        }

        return $result;
    }

    public function getText(): string
    {
        return implode("", array_map(function ($node) {
            return $node->textContent;
        }, $this->getContentChildren()));
    }

    public function _new_r(): CTRegularTextRun
    {
        $xml = sprintf("<a:r %s><a:t/></a:r>", nsdecls("a"));

        $obj = makeOXmlElement($this->ownerDocument, $xml);
        assert($obj instanceof CTRegularTextRun);
        return $obj;
    }
}