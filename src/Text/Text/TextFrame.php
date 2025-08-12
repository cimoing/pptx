<?php

namespace Imoing\Pptx\Text\Text;

use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\OXml\Drawing\CTListStyle;
use Imoing\Pptx\OXml\Text\CTTextBody;
use Imoing\Pptx\OXml\Text\CTTextParagraph;
use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Shapes\Subshape;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property-read Paragraph[] $paragraphs
 * @property string $text
 * @property-read bool $isVertical
 */
class TextFrame extends Subshape
{
    protected CTTextBody $_element;
    protected CTTextBody $_txBody;

    public function __construct(CTTextBody $txBody, Shape $parent)
    {
        parent::__construct($parent);
        $this->_parent = $parent;
        $this->_txBody = $this->_element = $txBody;
    }

    public function getParagraphs(): array
    {
        $items = [];
        foreach ($this->_txBody->p_lst as $p) {
            $items[] = new Paragraph($p, $this);
        }
        return $items;
    }

    public function addParagraph(): Paragraph
    {
        $p = $this->_txBody->add_p();
        return new Paragraph($p, $this);
    }

    public function getText(): string
    {
        $items = [];
        foreach ($this->paragraphs as $p) {
            $items[] = $p->text;
        }

        return implode("\n", $items);

    }

    public function setText(string $text): void
    {
        $txBody = $this->_txBody;
        $txBody->clearContent();
        $lines = explode("\n", $text);
        foreach ($lines as $line) {
            $p = $txBody->add_p();
            $p->append_text($line);
        }
    }

    public function getListStyle(): CTListStyle
    {
        return $this->_element->lstStyle;
    }

    public function getLevelPPr(int $level): ?CTLevelParaProperties
    {
        $lstStyle = $this->getListStyle();
        $pPr = $lstStyle->{"lvl{$level}pPr"};
        if ($pPr) {
            return $pPr;
        }

        return $this->_parent->getLevelPPr($level);
    }

    public function getIsVertical(): bool
    {
        return $this->_txBody->bodyPr->vert === 'eaVert';
    }

    public function toHtml(): string
    {
        $lastTag = '';
        $html = '';
        foreach ($this->paragraphs as $p) {
            $tag = $p->getHtmlLiTag();
            if ($tag !== $lastTag) {
                if (!empty($lastTag)) {
                    $html = "</$lastTag>";
                }
                $lastTag = $tag;
                $html .= "<$tag>";
            }
            $html .= $p->toHtml();
        }
        if (!empty($lastTag)) {
            $html .= "</$lastTag>";
        }

        if ($html === "<p></p>") {
            $html = "";
        }

        return $html;
    }
}