<?php

namespace Imoing\Pptx\Text\Text;

use Imoing\Pptx\OXml\Text\CTTextBody;
use Imoing\Pptx\OXml\Text\CTTextParagraph;
use Imoing\Pptx\Shapes\Subshape;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property-read Paragraph[] $paragraphs
 * @property string $text
 */
class TextFrame extends Subshape
{
    protected CTTextBody $_element;
    protected CTTextBody $_txBody;

    public function __construct(CTTextBody $txBody, ProvidesPart $parent)
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
}