<?php
namespace Imoing\Pptx\Enum;

enum XlCategoryType: int
{
    case AUTOMATIC_SCALE = -4105;
    case CATEGORY_SCALE = 2;
    case TIME_SCALE = 3;

    public function description(): string
    {
        return match ($this) {
            self::AUTOMATIC_SCALE => 'The application controls the axis type.',
            self::CATEGORY_SCALE => 'Axis groups data by an arbitrary set of categories',
            self::TIME_SCALE => 'Axis groups data on a time scale of days, months, or years.',
        };
    }

    public function toString(): string
    {
        return "{$this->name} ({$this->value})";
    }
}
