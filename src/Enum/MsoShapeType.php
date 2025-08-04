<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;

enum MsoShapeType: int implements IBaseEnum
{
    use TraitEnum;
    case AUTO_SHAPE = 1;
    case CALLOUT = 2;
    case CANVAS = 20;
    case CHART = 3;
    case COMMENT = 4;
    case DIAGRAM = 21;
    case EMBEDDED_OLE_OBJECT = 7;
    case FORM_CONTROL = 8;
    case FREEFORM = 5;
    case GROUP = 6;
    case IGX_GRAPHIC = 24;
    case INK = 22;
    case INK_COMMENT = 23;
    case LINE = 9;
    case LINKED_OLE_OBJECT = 10;
    case LINKED_PICTURE = 11;
    case MEDIA = 16;
    case OLE_CONTROL_OBJECT = 12;
    case PICTURE = 13;
    case PLACEHOLDER = 14;
    case SCRIPT_ANCHOR = 18;
    case TABLE = 19;
    case TEXT_BOX = 17;
    case TEXT_EFFECT = 15;
    case WEB_VIDEO = 26;
    case MIXED = -2;


    public function getDescription(): string
    {
        return match ($this) {
            self::AUTO_SHAPE => "AutoShape",
            self::CALLOUT => "Callout shape",
            self::CANVAS => "Drawing canvas",
            self::CHART => "Chart, e.g. pie chart, bar chart",
            self::COMMENT => "Comment",
            self::DIAGRAM => "Diagram",
            self::EMBEDDED_OLE_OBJECT => "Embedded OLE object",
            self::FORM_CONTROL => "Form control",
            self::FREEFORM => "Freeform",
            self::GROUP => "Group shape",
            self::IGX_GRAPHIC => "SmartArt graphic",
            self::INK => "Ink",
            self::INK_COMMENT => "Ink Comment",
            self::LINE => "Line",
            self::LINKED_OLE_OBJECT => "Linked OLE object",
            self::LINKED_PICTURE => "Linked picture",
            self::MEDIA => "Media",
            self::OLE_CONTROL_OBJECT => "OLE control object",
            self::PICTURE => "Picture",
            self::PLACEHOLDER => "Placeholder",
            self::SCRIPT_ANCHOR => "Script anchor",
            self::TABLE => "Table",
            self::TEXT_BOX => "Text box",
            self::TEXT_EFFECT => "Text effect",
            self::WEB_VIDEO => "Web video",
            self::MIXED => "Multiple shape types (read-only).",
        };
    }
}