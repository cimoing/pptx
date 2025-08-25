<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseXmlEnum;
use Imoing\Pptx\Enum\Base\TraitXmlEnum;

enum PPPlaceholderType: int implements IBaseXmlEnum
{
    use TraitXmlEnum;
    case BITMAP = 9;
    case BODY = 2;
    case CENTER_TITLE = 3;
    case CHART = 8;
    case DATE = 16;
    case FOOTER = 15;
    case HEADER = 14;
    case MEDIA_CLIP = 10;
    case OBJECT = 7;
    case ORG_CHART = 11;
    case PICTURE = 18;
    case SLIDE_IMAGE = 101;
    case SLIDE_NUMBER = 13;
    case SUBTITLE = 4;
    case TABLE = 12;
    case TITLE = 1;
    case VERTICAL_BODY = 6;
    case VERTICAL_OBJECT = 17;
    case VERTICAL_TITLE = 5;
    case MIXED = -2;


    public static function getXmlValues(): array
    {
        return [
            self::BITMAP->value => ["clipArt", "Clip art placeholder"],
            self::BODY->value => ["body", "Body"],
            self::CENTER_TITLE->value => ["ctrTitle", "Center Title"],
            self::CHART->value => ["chart", "Chart"],
            self::DATE->value => ["dt", "Date"],
            self::FOOTER->value => ["ftr", "Footer"],
            self::HEADER->value => ["hdr", "Header"],
            self::MEDIA_CLIP->value => ["media", "Media Clip"],
            self::OBJECT->value => ["obj", "Object"],
            self::ORG_CHART->value => ["dgm", "SmartArt placeholder. Organization chart is a legacy name."],
            self::PICTURE->value => ["pic", "Picture"],
            self::SLIDE_IMAGE->value => ["sldImg", "Slide Image"],
            self::SLIDE_NUMBER->value => ["sldNum", "Slide Number"],
            self::SUBTITLE->value => ["subTitle", "Subtitle"],
            self::TABLE->value => ["tbl", "Table"],
            self::TITLE->value => ["title", "Title"],
            self::VERTICAL_BODY->value => ["", "Vertical Body (read-only)."],
            self::VERTICAL_OBJECT->value => ["", "Vertical Object (read-only)."],
            self::VERTICAL_TITLE->value => ["", "Vertical Title (read-only)."],
            self::MIXED->value => ["", "Return value only; multiple placeholders of differing types."],
        ];
    }

    public function getHtmlValue(): string
    {
        return match ($this->value) {
            self::BITMAP->value => 'bitmap',
            self::BODY->value, self::VERTICAL_BODY->value => 'content',
            self::CENTER_TITLE->value, self::TITLE->value, self::VERTICAL_TITLE->value => 'title',
            self::CHART->value => 'chart',
            self::DATE->value => 'date',
            self::FOOTER->value => 'footer',
            self::HEADER->value => 'header',
            self::MEDIA_CLIP->value => 'media',
            self::OBJECT->value, self::VERTICAL_OBJECT->value => 'object',
            self::ORG_CHART->value => 'dgm',
            self::PICTURE->value => 'pic',
            self::SLIDE_IMAGE->value => 'sldImg',
            self::SLIDE_NUMBER->value => 'sldNum',
            self::SUBTITLE->value => 'subTitle',
            self::TABLE->value => 'table',
            self::MIXED->value => '',
        };
    }

    public function isMajor(): bool
    {
        return $this === self::TITLE || $this === self::CENTER_TITLE;
    }
}
