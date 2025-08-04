<?php
namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;

enum MsoColorType: int implements IBaseEnum
{
    use TraitEnum;

    case RGB = 1;
    case SCHEME = 2;
    case HSL = 101;
    case PRESET = 102;
    case SCRGB = 103;
    case SYSTEM = 104;

    public function getDescription(): string
    {
        return match ($this) {
            self::RGB => 'Color is specified by an RGBColor value.',
            self::SCHEME => 'Color is one of the preset theme colors',
            self::HSL => 'Color is specified using Hue, Saturation, and Luminosity values',
            self::PRESET => 'Color is specified using a named built-in color',
            self::SCRGB => 'Color is an scRGB color, a wide color gamut RGB color space',
            self::SYSTEM => 'Color is one specified by the operating system, such as the window background color.',
        };
    }
}
