<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\IBaseXmlEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;
use Imoing\Pptx\Enum\Base\TraitXmlEnum;

enum MsoTextUnderlineType: int implements IBaseXmlEnum
{
    use TraitXmlEnum;
    case NONE = 0;
    case DASH_HEAVY_LINE = 8;
    case DASH_LINE = 7;
    case DASH_LONG_HEAVY_LINE = 10;
    case DASH_LONG_LINE = 9;
    case DOT_DASH_HEAVY_LINE = 12;
    case DOT_DASH_LINE = 11;
    case DOT_DOT_DASH_HEAVY_LINE = 14;
    case DOT_DOT_DASH_LINE = 13;
    case DOTTED_HEAVY_LINE = 6;
    case DOTTED_LINE = 5;
    case DOUBLE_LINE = 3;
    case HEAVY_LINE = 4;
    case SINGLE_LINE = 2;
    case WAVY_DOUBLE_LINE = 17;
    case WAVY_HEAVY_LINE = 16;
    case WAVY_LINE = 15;
    case WORDS = 1;
    case MIXED = -2;

    public static function getXmlValues(): array
    {
        return [
            self::NONE->value => ['none', 'Specifies no underline.'],
            self::DASH_HEAVY_LINE->value => ['dashHeavy', 'Specifies a dash underline.'],
            self::DASH_LINE->value => ['dash', 'Specifies a dash line underline.'],
            self::DASH_LONG_HEAVY_LINE->value => ['dashLongHeavy', 'Specifies a long heavy line underline.'],
            self::DASH_LONG_LINE->value => ['dashLong', 'Specifies a dashed long line underline.'],
            self::DOT_DASH_HEAVY_LINE->value => ['dotDashHeavy', 'Specifies a dot dash heavy line underline.'],
            self::DOT_DASH_LINE->value => ['dotDash', 'Specifies a dot dash line underline.'],
            self::DOT_DOT_DASH_HEAVY_LINE->value => ['dotDotDashHeavy', 'Specifies a dot dot dash heavy line underline.'],
            self::DOT_DOT_DASH_LINE->value => ['dotDotDash', 'Specifies a dot dot dash line underline.'],
            self::DOTTED_HEAVY_LINE->value => ['dottedHeavy', 'Specifies a dotted heavy line underline.'],
            self::DOTTED_LINE->value => ['dotted', 'Specifies a dotted line underline.'],
            self::DOUBLE_LINE->value => ['dbl', 'Specifies a double line underline.'],
            self::HEAVY_LINE->value => ['heavy', 'Specifies a heavy line underline.'],
            self::SINGLE_LINE->value => ['sng', 'Specifies a single line underline.'],
            self::WAVY_DOUBLE_LINE->value => ['wavyDbl', 'Specifies a wavy double line underline.'],
            self::WAVY_HEAVY_LINE->value => ['wavyHeavy', 'Specifies a wavy heavy line underline.'],
            self::WAVY_LINE->value => ['wavy', 'Specifies a wavy line underline.'],
            self::WORDS->value => ['words', 'Specifies underlining words.'],
            self::MIXED->value => ['', 'Specifies a mix of underline types (read-only).'],
        ];
    }
}