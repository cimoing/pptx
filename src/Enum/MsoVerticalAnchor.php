<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\IBaseXmlEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;
use Imoing\Pptx\Enum\Base\TraitXmlEnum;

enum MsoVerticalAnchor: int implements IBaseXmlEnum
{
    use TraitXmlEnum;
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

    public static function getXmlValues(): array
    {
        return [
            self::TOP->value => ['t', 'Aligns text to top of text frame'],
            self::BOTTOM->value => ['b', 'Centers text vertically'],
            self::MIDDLE->value => ['ctr', 'Aligns text to bottom of text frame'],
            self::MIXED->value => ['mixed', 'Return value only; indicates a combination of the other states.'],
        ];
    }

    public function getHtmlValue(): string
    {
        return match ($this) {
            self::TOP => 'start',
            self::MIDDLE, self::MIXED => 'center',
            self::BOTTOM => 'end',
        };
    }
}