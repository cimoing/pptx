<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;

enum PPMediaType: int implements IBaseEnum
{
    use TraitEnum;
    case MOVIE = 3;
    case OTHER = 1;
    case MIXED = -2;


    public function getDescription(): string
    {
        return match ($this) {
            self::MOVIE => "Video media such as MP4.",
            self::OTHER => "Other media types",
            self::MIXED => "Return value only; indicates multiple media types, typically for a collection of shapes. May not be applicable in python-pptx.",
        };
    }
}