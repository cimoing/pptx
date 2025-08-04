<?php

namespace Imoing\Pptx\Text\Text;

use Imoing\Pptx\OXml\Text\CTTextParagraph;
use Imoing\Pptx\Shapes\Subshape;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property string $text
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

    public function clear(): self
    {
        foreach ($this->_element->contentChildren as $elm) {
            $this->_element->removeChild($elm->element);
        }
        return $this;
    }
}