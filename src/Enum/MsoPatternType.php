<?php
namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\TraitXmlEnum;

enum MsoPatternType: int
{
    use TraitXmlEnum;
    case CROSS = 51;
    case DARK_DOWNWARD_DIAGONAL = 15;
    case DARK_HORIZONTAL = 13;
    case DARK_UPWARD_DIAGONAL = 16;
    case DARK_VERTICAL = 14;
    case DASHED_DOWNWARD_DIAGONAL = 28;
    case DASHED_HORIZONTAL = 32;
    case DASHED_UPWARD_DIAGONAL = 27;
    case DASHED_VERTICAL = 31;
    case DIAGONAL_BRICK = 40;
    case DIAGONAL_CROSS = 54;
    case DIVOT = 46;
    case DOTTED_DIAMOND = 24;
    case DOTTED_GRID = 45;
    case DOWNWARD_DIAGONAL = 52;
    case HORIZONTAL = 49;
    case HORIZONTAL_BRICK = 35;
    case LARGE_CHECKER_BOARD = 36;
    case LARGE_CONFETTI = 33;
    case LARGE_GRID = 34;
    case LIGHT_DOWNWARD_DIAGONAL = 21;
    case LIGHT_HORIZONTAL = 19;
    case LIGHT_UPWARD_DIAGONAL = 22;
    case LIGHT_VERTICAL = 20;
    case NARROW_HORIZONTAL = 30;
    case NARROW_VERTICAL = 29;
    case OUTLINED_DIAMOND = 41;
    case PERCENT_10 = 2;
    case PERCENT_20 = 3;
    case PERCENT_25 = 4;
    case PERCENT_30 = 5;
    case ERCENT_40 = 6;
    case PERCENT_5 = 1;
    case PERCENT_50 = 7;
    case PERCENT_60 = 8;
    case PERCENT_70 = 9;
    case PERCENT_75 = 10;
    case PERCENT_80 = 11;
    case PERCENT_90 = 12;
    case PLAID = 42;
    case SHINGLE = 47;
    case SMALL_CHECKER_BOARD = 17;
    case SMALL_CONFETTI = 37;
    case SMALL_GRID = 23;
    case SOLID_DIAMOND = 39;
    case SPHERE = 43;
    case TRELLIS = 18;
    case UPWARD_DIAGONAL = 53;
    case VERTICAL = 50;
    case WAVE = 48;
    case WEAVE = 44;
    case WIDE_DOWNWARD_DIAGONAL = 25;
    case WIDE_UPWARD_DIAGONAL = 26;
    case ZIG_ZAG = 38;
    case MIXED = -2;

    public function getXmlValues(): array
    {
        return [
            self::CROSS->value => ["cross", "Cross"],
            self::DARK_DOWNWARD_DIAGONAL->value => ["dkDnDiag", "Dark Downward Diagonal"],
            self::DARK_HORIZONTAL->value => ["dkHorz", "Dark Horizontal"],
            self::DARK_UPWARD_DIAGONAL->value => ["dkUpDiag", "Dark Upward Diagonal"],
            self::DARK_VERTICAL->value => ["dkVert", "Dark Vertical"],
            self::DASHED_DOWNWARD_DIAGONAL->value => ["dashDnDiag", "Dashed Downward Diagonal"],
            self::DASHED_HORIZONTAL->value => ["dashHorz", "Dashed Horizontal"],
            self::DASHED_UPWARD_DIAGONAL->value => ["dashUpDiag", "Dashed Upward Diagonal"],
            self::DASHED_VERTICAL->value => ["dashVert", "Dashed Vertical"],
            self::DIAGONAL_BRICK->value => ["diagBrick", "Diagonal Brick"],
            self::DIAGONAL_CROSS->value => ["diagCross", "Diagonal Cross"],
            self::DIVOT->value => ["divot", "Pattern Divot"],
            self::DOTTED_DIAMOND->value => ["dotDmnd", "Dotted Diamond"],
            self::DOTTED_GRID->value => ["dotGrid", "Dotted Grid"],
            self::DOWNWARD_DIAGONAL->value => ["dnDiag", "Downward Diagonal"],
            self::HORIZONTAL->value => ["horz", "Horizontal"],
            self::HORIZONTAL_BRICK->value => ["horzBrick", "Horizontal Brick"],
            self::LARGE_CHECKER_BOARD->value => ["lgCheck", "Large Checker Board"],
            self::LARGE_CONFETTI->value => ["lgConfetti", "Large Confetti"],
            self::LARGE_GRID->value => ["lgGrid", "Large Grid"],
            self::LIGHT_DOWNWARD_DIAGONAL->value => ["ltDnDiag", "Light Downward Diagonal"],
            self::LIGHT_HORIZONTAL->value => ["ltHorz", "Light Horizontal"],
            self::LIGHT_UPWARD_DIAGONAL->value => ["ltUpDiag", "Light Upward Diagonal"],
            self::LIGHT_VERTICAL->value => ["ltVert", "Light Vertical"],
            self::NARROW_HORIZONTAL->value => ["narHorz", "Narrow Horizontal"],
            self::NARROW_VERTICAL->value => ["narVert", "Narrow Vertical"],
            self::OUTLINED_DIAMOND->value => ["openDmnd", "Outlined Diamond"],
            self::PERCENT_10->value => ["pct10", "10% of the foreground color."],
            self::PERCENT_20->value => ["pct20", "20% of the foreground color."],
            self::PERCENT_25->value => ["pct25", "25% of the foreground color."],
            self::PERCENT_30->value => ["pct30", "30% of the foreground color."],
            self::ERCENT_40->value => ["pct40", "40% of the foreground color."],
            self::PERCENT_5->value => ["pct5", "5% of the foreground color."],
            self::PERCENT_50->value => ["pct50", "50% of the foreground color."],
            self::PERCENT_60->value => ["pct60", "60% of the foreground color."],
            self::PERCENT_70->value => ["pct70", "70% of the foreground color."],
            self::PERCENT_75->value => ["pct75", "75% of the foreground color."],
            self::PERCENT_80->value => ["pct80", "80% of the foreground color."],
            self::PERCENT_90->value => ["pct90", "90% of the foreground color."],
            self::PLAID->value => ["plaid", "Plaid"],
            self::SHINGLE->value => ["shingle", "Shingle"],
            self::SMALL_CHECKER_BOARD->value => ["smCheck", "Small Checker Board"],
            self::SMALL_CONFETTI->value => ["smConfetti", "Small Confetti"],
            self::SMALL_GRID->value => ["smGrid", "Small Grid"],
            self::SOLID_DIAMOND->value => ["solidDmnd", "Solid Diamond"],
            self::SPHERE->value => ["sphere", "Sphere"],
            self::TRELLIS->value => ["trellis", "Trellis"],
            self::UPWARD_DIAGONAL->value => ["upDiag", "Upward Diagonal"],
            self::VERTICAL->value => ["vert", "Vertical"],
            self::WAVE->value => ["wave", "Wave"],
            self::WEAVE->value => ["weave", "Weave"],
            self::WIDE_DOWNWARD_DIAGONAL->value => ["wdDnDiag", "Wide Downward Diagonal"],
            self::WIDE_UPWARD_DIAGONAL->value => ["wdUpDiag", "Wide Upward Diagonal"],
            self::ZIG_ZAG->value => ["zigZag", "Zig Zag"],
            self::MIXED->value => ["", "Mixed pattern (read-only)."],
        ];
    }
}