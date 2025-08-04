<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;

enum MsoVerticalAnchor: int implements IBaseEnum
{
    use TraitEnum;
    case TOP = 1;
    case MIDDLE = 3;
    case BOTTOM = 4;
    case MIXED = -2;


    public function getDescription(): string
    {
        return match ($this) {
            self::TOP => "Aligns text to top of text frame",
            self::MIDDLE => "Centers text vertically",
            self::BOTTOM => "Aligns text to bottom of text frame",
            self::MIXED => "Return value only; indicates a combination of the other states.",
        };
    }
}