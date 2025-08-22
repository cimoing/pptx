<?php

namespace Imoing\Pptx\Text\Text;

use Imoing\Pptx\OXml\Text\CTRegularTextRun;
use Imoing\Pptx\Shapes\Subshape;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property string $text
 * @property-read Font $font
 */

class Run extends Subshape
{
    private CTRegularTextRun $_r;
    public function __construct(CTRegularTextRun $r, ProvidesPart $parent)
    {
        parent::__construct($parent);
        $this->_r = $r;
    }

    public function getFont(): Font
    {
        $rPr = $this->_r->get_or_add_rPr();
        return new Font($rPr, null, $this->_parent->theme);
    }

    //TODO hyperlink

    public function getText(): string
    {
        return $this->_r->text;
    }

    public function setText(string $text): void
    {
        $this->_r->text = $text;
    }
}