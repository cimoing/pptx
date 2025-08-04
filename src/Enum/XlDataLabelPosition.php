<?php
namespace Imoing\Pptx\Enum;

enum XlDataLabelPosition: int
{
    case ABOVE = 0;
    case BELOW = 1;
    case BEST_FIT = 5;
    case CENTER = -4108;
    case INSIDE_BASE = 4;
    case INSIDE_END = 3;
    case LEFT = -4131;
    case MIXED = 6;
    case OUTSIDE_END = 2;
    case RIGHT = -4152;

    public function description(): string
    {
        return match ($this) {
            self::ABOVE => 'The data label is positioned above the data point.',
            self::BELOW => 'The data label is positioned below the data point.',
            self::BEST_FIT => 'Word sets the position of the data label.',
            self::CENTER => 'The data label is centered on the data point or inside a bar or a pie slice.',
            self::INSIDE_BASE => 'The data label is positioned inside the data point at the bottom edge.',
            self::INSIDE_END => 'The data label is positioned inside the data point at the top edge.',
            self::LEFT => 'The data label is positioned to the left of the data point.',
            self::MIXED => 'Data labels are in multiple positions (read-only).',
            self::OUTSIDE_END => 'The data label is positioned outside the data point at the top edge.',
            self::RIGHT => 'The data label is positioned to the right of the data point.',
        };
    }

    public function toString(): string
    {
        return "{$this->name} ({$this->value})";
    }
}
