<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;

enum PPParagraphAlignment: int implements IBaseEnum
{
    use TraitEnum;
    case CENTER = 2;
    case DISTRIBUTE = 5;
    case JUSTIFY = 4;
    case JUSTIFY_LOW = 7;
    case LEFT = 1;
    case RIGHT = 3;
    case THAI_DISTRIBUTE = 6;
    case MIXED = -2;


    public function getDescription(): string
    {
        return match ($this) {
            self::CENTER => "Center align",
            self::DISTRIBUTE => "Evenly distributes e.g. Japanese characters from left to right within a line",
            self::JUSTIFY => "Justified, i.e. each line both begins and ends at the margin.

Spacing between words is adjusted such that the line exactly fills the width of the paragraph.",
            self::JUSTIFY_LOW => "Justify using a small amount of space between words.",
            self::LEFT => "Left aligned",
            self::RIGHT => "Right aligned",
            self::THAI_DISTRIBUTE => "Thai distributed",
            self::MIXED => "Multiple alignments are present in a set of paragraphs (read-only).",
        };
    }
}