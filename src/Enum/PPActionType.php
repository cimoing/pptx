<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\TraitEnum;

enum PPActionType: int
{
    use TraitEnum;
    case END_SHOW = 6;
    case FIRST_SLIDE = 3;
    case HYPERLINK = 7;
    case LAST_SLIDE = 4;
    case LAST_SLIDE_VIEWED = 5;
    case NAMED_SLIDE = 101;
    case NAMED_SLIDE_SHOW = 10;
    case NEXT_SLIDE = 1;
    case NONE = 0;
    case OPEN_FILE = 102;
    case OLE_VERB = 11;
    case PLAY = 12;
    case PREVIOUS_SLIDE = 2;
    case RUN_MACRO = 8;
    case RUN_PROGRAM = 9;

    /**
     * 获取每个枚举值的描述文本
     */
    public function getDescription(): string {
        return match($this) {
            self::END_SHOW => 'Slide show ends.',
            self::FIRST_SLIDE => 'Returns to the first slide.',
            self::HYPERLINK => 'Hyperlink.',
            self::LAST_SLIDE => 'Moves to the last slide.',
            self::LAST_SLIDE_VIEWED => 'Moves to the last slide viewed.',
            self::NAMED_SLIDE => 'Moves to slide specified by slide number.',
            self::NAMED_SLIDE_SHOW => 'Runs the slideshow.',
            self::NEXT_SLIDE => 'Moves to the next slide.',
            self::NONE => 'No action is performed.',
            self::OPEN_FILE => 'Opens the specified file.',
            self::OLE_VERB => 'OLE Verb.',
            self::PLAY => 'Begins the slideshow.',
            self::PREVIOUS_SLIDE => 'Moves to the previous slide.',
            self::RUN_MACRO => 'Runs a macro.',
            self::RUN_PROGRAM => 'Runs a program.',
        };
    }

    /**
     * 输出格式如：NEXT_SLIDE (1)
     */
    public function toString(): string {
        return "{$this->name} ({$this->value})";
    }
}