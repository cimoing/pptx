<?php
namespace Imoing\Pptx\Enum;

enum XlLegendPosition: int
{
    case BOTTOM = -4107;
    case CORNER = 2;
    case CUSTOM = -4161;
    case LEFT = -4131;
    case RIGHT = -4152;
    case TOP = -4160;

    public function description(): string
    {
        return match ($this) {
            self::BOTTOM => 'Below the chart.',
            self::CORNER => 'In the upper-right corner of the chart border.',
            self::CUSTOM => 'A custom position (read-only).',
            self::LEFT => 'Left of the chart.',
            self::RIGHT => 'Right of the chart.',
            self::TOP => 'Above the chart.',
        };
    }

    public function toString(): string
    {
        return "{$this->name} ({$this->value})";
    }
}
