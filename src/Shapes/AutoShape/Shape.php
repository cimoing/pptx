<?php

namespace Imoing\Pptx\Shapes\AutoShape;

use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Dml\Line\LineFormat;
use Imoing\Pptx\Enum\MsoAutoShapeType;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;
use Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Text\Text\TextFrame;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property-read  TextFrame $textFrame
 * @property string $text
 * @property-read ?MsoAutoShapeType $autoShapeType
 * @property-read FillFormat $fill
 * @property-read bool $hasTextFrame
 */
class Shape extends BaseShape
{
    protected CTShape $_sp;
    public function __construct(CTShape $shape, ProvidesPart $part)
    {
        parent::__construct($shape, $part);
        $this->_sp = $shape;
    }

    public function getAutoShapeType(): ?\Imoing\Pptx\Enum\MsoAutoShapeType
    {
        if (!($this->_sp->isAutoShape)) {
            throw new \Exception("shape is not an auto shape");
        }

        return $this->_sp->prst;
    }

    private ?FillFormat $_fill = null;
    public function getFill(): FillFormat
    {
        if (is_null($this->_fill)) {
            $this->_fill = FillFormat::fromFillParent($this->_sp->spPr);
        }

        return $this->_fill;
    }

    public function get_or_add_ln(): CTLineProperties
    {
        return $this->_sp->get_or_add_ln();
    }

    public function getHasTextFrame(): bool
    {
        return true;
    }

    private ?LineFormat $_line = null;
    public function getLine(): LineFormat
    {
        if (is_null($this->_line)) {
            $this->_line = new LineFormat($this);
        }

        return $this->_line;
    }

    private ?CTLineProperties $_ln = null;
    public function getLn(): CTLineProperties
    {
        if (is_null($this->_ln)) {
            $this->_ln = $this->_sp->ln;
        }
        return $this->_ln;
    }

    public function getShapeType(): MsoShapeType
    {
        if ($this->isPlaceholder) {
            return MsoShapeType::PLACEHOLDER;
        }
        if ($this->_sp->getHasCustomGeometry()) {
            return MsoShapeType::FREEFORM;
        }
        if ($this->_sp->getIsTextBox()) {
            return MsoShapeType::TEXT_BOX;
        }

        throw new \Exception("Shape instance of unrecognized shape type");
    }

    public function getText(): string
    {
        return $this->textFrame->text;
    }

    public function setText(string $text): void
    {
        $this->textFrame->text = $text;
    }

    public function getTextFrame(): TextFrame
    {
        $txBody = $this->_sp->get_or_add_txBody();
        return new TextFrame($txBody, $this);
    }
}