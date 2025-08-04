<?php
namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\TraitXmlEnum;

enum MsoThemeColorIndex: int
{
    use TraitXmlEnum;
    case NOT_THEME_COLOR = 0;
    case ACCENT_1 = 5;
    case ACCENT_2 = 6;
    case ACCENT_3 = 7;
    case ACCENT_4 = 8;
    case ACCENT_5 = 9;
    case ACCENT_6 = 10;
    case BACKGROUND_1 = 14;
    case BACKGROUND_2 = 16;
    case DARK_1 = 1;
    case DARK_2 = 3;
    case FOLLOWED_HYPERLINK = 12;
    case HYPERLINK = 11;
    case LIGHT_1 = 2;
    case LIGHT_2 = 4;
    case TEXT_1 = 13;
    case TEXT_2 = 15;
    case MIXED = -2;

    public function getXmlValues(): array
    {
        return [
            self::NOT_THEME_COLOR->value => ["", "Indicates the color is not a theme color."],
            self::ACCENT_1->value => ["accent1", "Specifies the Accent 1 theme color."],
            self::ACCENT_2->value => ["accent2", "Specifies the Accent 2 theme color."],
            self::ACCENT_3->value => ["accent3", "Specifies the Accent 3 theme color."],
            self::ACCENT_4->value => ["accent4", "Specifies the Accent 4 theme color."],
            self::ACCENT_5->value => ["accent5", "Specifies the Accent 5 theme color."],
            self::ACCENT_6->value => ["accent6", "Specifies the Accent 6 theme color."],
            self::BACKGROUND_1->value => ["bg1", "Specifies the Background 1 theme color."],
            self::BACKGROUND_2->value => ["bg2", "Specifies the Background 2 theme color."],
            self::DARK_1->value => ["dk1", "Specifies the Dark 1 theme color."],
            self::DARK_2->value => ["dk2", "Specifies the Dark 2 theme color."],
            self::FOLLOWED_HYPERLINK->value => ["folHlink", "Specifies the theme color for a clicked hyperlink."],
            self::HYPERLINK->value => ["hlink", "Specifies the theme color for a hyperlink."],
            self::LIGHT_1->value => ["lt1", "Specifies the Light 1 theme color."],
            self::LIGHT_2->value => ["lt2", "Specifies the Light 2 theme color."],
            self::TEXT_1->value => ["tx1", "Specifies the Text 1 theme color."],
            self::TEXT_2->value => ["tx2", "Specifies the Text 2 theme color."],
            self::MIXED->value => ["", "Indicates multiple theme colors are used, such as in a group shape (read-only)."],
        ];
    }
}
