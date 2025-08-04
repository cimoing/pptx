<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;

enum MsoAutoSize: int implements IBaseEnum
{
    use TraitEnum;
    case NONE = 0;
    case SHAPE_TO_FIT_TEXT = 1;
    case TEXT_TO_FIT_SHAPE = 2;
    case MIXED = -2;


    public function getDescription(): string
    {
        return match ($this) {
            self::NONE => "No automatic sizing of the shape or text will be done.

Text can freely extend beyond the horizontal and vertical edges of the shape bounding box.",
            self::SHAPE_TO_FIT_TEXT => "The shape height and possibly width are adjusted to fit the text.

Note this setting interacts with the TextFrame.word_wrap property setting. If word wrap is turned on, only the height of the shape will be adjusted; soft line breaks will be used to fit the text horizontally.",
            self::TEXT_TO_FIT_SHAPE => "The font size is reduced as necessary to fit the text within the shape.",
            self::MIXED => "Return value only; indicates a combination of automatic sizing schemes are used.",
        };
    }
}