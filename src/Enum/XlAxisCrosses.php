<?php
namespace Imoing\Pptx\Enum;

enum XlAxisCrosses: int
{
    case AUTOMATIC = -4105;
    case CUSTOM = -4114;
    case MAXIMUM = 2;
    case MINIMUM = 4;

    public function description(): string
    {
        return match ($this) {
            self::AUTOMATIC => 'The axis crossing point is set automatically, often at zero.',
            self::CUSTOM => 'The .crosses_at property specifies the axis crossing point.',
            self::MAXIMUM => 'The axis crosses at the maximum value.',
            self::MINIMUM => 'The axis crosses at the minimum value.',
        };
    }

    public function toString(): string
    {
        return "{$this->name} ({$this->value})";
    }
}
