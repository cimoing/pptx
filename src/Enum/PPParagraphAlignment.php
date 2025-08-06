<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\IBaseXmlEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;
use Imoing\Pptx\Enum\Base\TraitXmlEnum;

enum PPParagraphAlignment: int implements IBaseXmlEnum
{
    use TraitXmlEnum;
    case CENTER = 2;
    case DISTRIBUTE = 5;
    case JUSTIFY = 4;
    case JUSTIFY_LOW = 7;
    case LEFT = 1;
    case RIGHT = 3;
    case THAI_DISTRIBUTE = 6;
    case MIXED = -2;

    public static function getXmlValues(): array
    {
        return [
            self::CENTER->value => ['ctr', 'PP_ALIGN'],
            self::DISTRIBUTE->value => ["dist", "Evenly distributes e.g. Japanese characters from left to right within a line"],
            self::JUSTIFY->value => [
                "just",
                "Justified, i.e. each line both begins and ends at the margin.\n\nSpacing between words".
                " is adjusted such that the line exactly fills the width of the paragraph."
            ],
            self::JUSTIFY_LOW->value => ["justLow", "Justify using a small amount of space between words."],
            self::LEFT->value => ["l", "Left aligned"],
            self::RIGHT->value => ["r", "Right aligned"],
            self::THAI_DISTRIBUTE->value => ["thaiDist", "Thai distributed"],
            self::MIXED->value => ["", "Multiple alignments are present in a set of paragraphs (read-only)."],
        ];
    }
}