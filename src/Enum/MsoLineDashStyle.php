<?php
namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\TraitXmlEnum;

enum MsoLineDashStyle: int
{
    use TraitXmlEnum;
    case DASH = 4;
    case DASH_DOT = 5;
    case DASH_DOT_DOT = 6;
    case LONG_DASH = 7;
    case LONG_DASH_DOT = 8;
    case ROUND_DOT = 3;
    case SOLID = 1;
    case SQUARE_DOT = 2;
    case DASH_STYLE_MIXED = -2;

    public function getXmlValues(): array
    {
        return [
            self::DASH->value => ["dash", "Line consists of dashes only."],
            self::DASH_DOT->value => ["dashDot", "Line is a dash-dot pattern."],
            self::DASH_DOT_DOT->value => ["lgDashDotDot", "Line is a dash-dot-dot pattern."],
            self::LONG_DASH->value => ["lgDash", "Line consists of long dashes."],
            self::LONG_DASH_DOT->value => ["lgDashDot", "Line is a long dash-dot pattern."],
            self::ROUND_DOT->value => ["sysDot", "Line is made up of round dots."],
            self::SOLID->value => ["solid", "Line is solid."],
            self::SQUARE_DOT->value => ["sysDash", "Line is made up of square dots."],
            self::DASH_STYLE_MIXED->value => ["", "Not supported."],
        ];
    }
}
