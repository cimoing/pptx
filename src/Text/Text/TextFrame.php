<?php

namespace Imoing\Pptx\Text\Text;

use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\OXml\Drawing\CTListStyle;
use Imoing\Pptx\OXml\Text\CTTextBody;
use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Shapes\Base\Theme;
use Imoing\Pptx\Shapes\Subshape;

/**
 * @property-read Paragraph[] $paragraphs
 * @property string $text
 * @property-read bool $isVertical
 * @property-read Theme $theme
 */
class TextFrame extends Subshape
{
    protected CTTextBody $_element;
    protected CTTextBody $_txBody;

    protected bool $isMajor = false;

    public function __construct(CTTextBody $txBody, Shape $parent)
    {
        parent::__construct($parent);
        $this->_parent = $parent;
        $this->_txBody = $this->_element = $txBody;
    }

    public function setMajor(bool $major): void
    {
        $this->isMajor = $major;
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

    public function getLevelStyles(int $level): array
    {
        $style = $this->_parent->getTextLevelParaStyle();
        $arr = $style->getStylesByLevel($level);
        if (empty($arr['font-family'])) {
            $arr['font-family'] = $this->isMajor ? $style->getMajorFont() : $style->getMinorFont();
        }

        return $arr;
    }

    public function getIsVertical(): bool
    {
        return $this->_txBody->bodyPr->vert === 'eaVert';
    }

    protected function getTheme(): Theme
    {
        return $this->_parent->theme;
    }

    public function getHtmlStyles(): array
    {
        $pr = $this->_txBody->bodyPr;
        if (!$pr) {
            return [];
        }

        return array_filter([
            'align-items' => $pr->anchor?->getHtmlValue(),
        ], function ($item) {
            return !is_null($item);
        });
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