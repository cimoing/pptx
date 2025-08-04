<?php
namespace Imoing\Pptx\Enum;

enum XlMarkerStyle: int
{
    case AUTOMATIC = -4105;
    case CIRCLE = 8;
    case DASH = -4115;
    case DIAMOND = 2;
    case DOT = -4118;
    case NONE = -4142;
    case PICTURE = -4147;

    public function description(): string
    {
        return match ($this) {
            self::AUTOMATIC => 'Automatic markers',
            self::CIRCLE => 'Circular markers',
            self::DASH => 'Long bar markers',
            self::DIAMOND => 'Diamond-shaped markers',
            self::DOT => 'Short bar markers',
            self::NONE => 'No markers',
            self::PICTURE => 'Picture markers',
        };
    }

    public function toString(): string
    {
        return "{$this->name} ({$this->value})";
    }
}
