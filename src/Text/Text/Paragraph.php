<?php

namespace Imoing\Pptx\Text\Text;

use Imoing\Pptx\Enum\PPParagraphAlignment;
use Imoing\Pptx\OXml\Text\CTRegularTextRun;
use Imoing\Pptx\OXml\Text\CTTextCharacterProperties;
use Imoing\Pptx\OXml\Text\CTTextField;
use Imoing\Pptx\OXml\Text\CTTextLineBreak;
use Imoing\Pptx\OXml\Text\CTTextParagraph;
use Imoing\Pptx\OXml\Text\CTTextParagraphProperties;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\Shapes\Base\TextLevelParaStyle;
use Imoing\Pptx\Shapes\Base\Theme;
use Imoing\Pptx\Shapes\Subshape;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property string $text
 * @property CTTextParagraphProperties $pPr
 * @property CTTextCharacterProperties $defRPr
 * @property-read TextFrame $_parent
 * @property-read Theme $theme
 */
class Paragraph extends Subshape
{
    protected CTTextParagraph $_element;
    protected CTTextParagraph $_p;
    public function __construct(CTTextParagraph $p, ProvidesPart $parent)
    {
        parent::__construct($parent);
        $this->_element = $this->_p = $p;
    }

    public function addLineBreak(): void
    {
        $this->_p->addBr();
    }

    public function addRun(): Run
    {
        $r = $this->_p->addR();
        return new Run($r, $this);
    }
    public function getAlignment(): ?PPParagraphAlignment
    {
        return $this->pPr->algn;
    }

    public function setAlignment(?PPParagraphAlignment $value): void
    {
        $this->pPr->algn = $value;
    }

    protected function getTheme(): Theme
    {
        return $this->_parent->theme;
    }

    public function clear(): self
    {
        foreach ($this->_element->contentChildren as $elm) {
            $this->_element->removeChild($elm->element);
        }
        return $this;
    }

    /**
     * @return int 默认层级为0
     */
    public function getLevel(): int
    {
        return $this->pPr->lvl ?: 0;
    }

    public function setLevel(int $value): void
    {
        $this->pPr->lvl = $value;
    }

    public function getRuns(): array
    {
        $items = [];
        foreach ($this->_element->r_lst as $r) {
            $items[] = new Run($r, $this);
        }

        return $items;
    }

    public function getText(): string
    {
        $items = [];
        foreach ($this->_element->contentChildren as $elm) {
            $items[] = $elm->textContent;
        }

        return implode("", $items);
    }

    public function setText(string $text): void
    {
        $this->clear();
        $this->_element->append_text($text);
    }



    /**
     * 判断使用何种列表,空则表示不使用列表
     * @return string
     */
    public function getHtmlLiTag(): string
    {
        if (!$this->_p->pPr) {
            return '';
        }

        if (!empty($this->_p->pPr->buChar)) {
            return 'ul';
        }
        if (!empty($this->_p->pPr->buAutoNum)) {
            return 'ol';
        }

        return '';
    }

    public function getHtmlStyle(): string
    {
        $styles = $this->_parent->getLevelStyles($this->getLevel());
        $overrides = [];
        $algn = $this->getAlignment();
        if (!empty($algn)) {
            $overrides['text-align'] = $algn->getHtmlValue();
        }
        $overrides = array_merge($overrides, TextLevelParaStyle::parseTextCharacter($this->_p->pPr?->defRPr, $this->theme));

        $styles = array_filter(array_merge($styles, $overrides), function ($style) {
            return !is_null($style);
        });

        $str = "";
        foreach ($styles as $style => $value) {
            $str .= $style . ": " . $value . "; ";
        }

        return $str;
    }

    public function getHtmlSpan(): string
    {
        $span = '';

        foreach ($this->_p->contentChildren as $child) {
            $fonts = $this->getChildFont($child);
            $style = implode(';', array_map(function ($key, $value) {
                return "$key: $value;";
            }, array_keys($fonts), $fonts));

            $style = empty($style) ? '' : " style=\"$style\"";

            // TODO link
            $text = $child->getHtmlText();
            // 替换制表符
            $text = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $text);
            // 替换空格
            $text = str_replace(" ", '&nbsp;', $text);
            $span .= "<span$style>$text</span>";
        }

        return $span;
    }

    /**
     * 获取子项的字体
     * @param  CTRegularTextRun|CTTextLineBreak|CTTextField $element
     * @return array
     */
    protected function getChildFont(CTRegularTextRun|CTTextLineBreak|CTTextField $element): array
    {
        return TextLevelParaStyle::parseTextCharacter($element->rPr, $this->theme);
    }

    public function toHtml(): string
    {
        $liTag = $this->getHtmlLiTag();
        $tag = empty($liTag) ? 'p' : 'li';
        $style = $this->getHtmlStyle();
        $style = empty($style) ? '' : " style=\"$style\"";

        return  "<$tag$style>{$this->getHtmlSpan()}</$tag>";
    }

    protected function getPPr(): CTTextParagraphProperties
    {
        return $this->_p->get_or_add_pPr();
    }

    protected function getDefRPr(): CTTextCharacterProperties
    {
        return $this->pPr->get_or_add_defRPr();
    }
}