<?php
namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\TraitEnum;

enum MsoFillType: int
{
    use TraitEnum;
    case BACKGROUND = 5;
    case GRADIENT = 3;
    case GROUP = 101;
    case PATTERNED = 2;
    case PICTURE = 6;
    case SOLID = 1;
    case TEXTURED = 4;

    public function getDescription(): string
    {
        return match ($this) {
            self::BACKGROUND => 'The shape is transparent, such that whatever is behind the shape shows through. Often this is the slide background, but if a visible shape is behind, that will show through.',
            self::GRADIENT => 'Shape is filled with a gradient',
            self::GROUP => 'Shape is part of a group and should inherit the fill properties of the group.',
            self::PATTERNED => 'Shape is filled with a pattern',
            self::PICTURE => 'Shape is filled with a bitmapped image',
            self::SOLID => 'Shape is filled with a solid color',
            self::TEXTURED => 'Shape is filled with a texture',
        };
    }

    public function toString(): string
    {
        return "{$this->name} ({$this->value})";
    }

    public function getJsonValue(): string
    {
        return match ($this) {
            self::BACKGROUND => 'none',
            self::PICTURE => 'image',
            self::SOLID => 'color',
            self::TEXTURED => 'textured',
            self::GRADIENT => 'gradient',
            self::PATTERNED => 'pattern',
            self::GROUP => 'group',
        };
    }
}
