<?php

namespace Imoing\Pptx\Shapes\AutoShape;

use AllowDynamicProperties;
use Exception;
use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Enum\MsoAutoShapeType;

#[AllowDynamicProperties]
class AutoShapeType extends BaseObject
{
    public static array $autoShapeTypes = [
        MsoAutoShapeType::ACTION_BUTTON_BACK_OR_PREVIOUS->value => [
            "basename" => "Action Button: Back or Previous",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_BEGINNING->value => [
            "basename" => "Action Button: Beginning",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_CUSTOM->value => [
            "basename" => "Action Button: Custom",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_DOCUMENT->value => [
            "basename" => "Action Button: Document",
            "avLst" => [

            ],
        ],
        MsoAutoShapeType::ACTION_BUTTON_END->value => [
            "basename" => "Action Button: End",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_FORWARD_OR_NEXT->value => [
            "basename" => "Action Button: Forward or Next",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_HELP->value => [
            "basename" => "Action Button: Help",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_HOME->value => [
            "basename" => "Action Button: Home",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_INFORMATION->value => [
            "basename" => "Action Button: Information",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_MOVIE->value => [
            "basename" => "Action Button: Movie",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_RETURN->value => [
            "basename" => "Action Button: Return",
            "avLst" => [],
        ],
        MsoAutoShapeType::ACTION_BUTTON_SOUND->value => [
            "basename" => "Action Button: Sound",
            "avLst" => [],
        ],
        MsoAutoShapeType::ARC->value => [
            "basename" => "Arc",
            "avLst" => [
                ["adj1", 16200000],
                ["adj2", 0],
            ],
        ],
        MsoAutoShapeType::BALLOON->value => [
            "basename" => "Rounded Rectangular Callout",
            "avLst" => [
                ["adj1", -20833],
                ["adj2", 62500],
                ["adj3", 16667],
            ],
        ],
        MsoAutoShapeType::BENT_ARROW->value => [
            "basename" => "Bent Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
                ["adj4", 43750],
            ],
        ],
        MsoAutoShapeType::BENT_UP_ARROW->value => [
            "basename" => "Bent-Up Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
            ],
        ],
        MsoAutoShapeType::BEVEL->value => [
            "basename" => "Bevel",
            "avLst" => [
                ["adj", 12500],
            ],
        ],
        MsoAutoShapeType::BLOCK_ARC->value => [
            "basename" => "Block Arc",
            "avLst" => [
                ["adj1", 10800000],
                ["adj2", 0],
                ["adj3", 25000],
            ],
        ],
        MsoAutoShapeType::CAN->value => [
            "basename" => "Can",
            "avLst" => [
                ["adj", 25000],
            ],
        ],
        MsoAutoShapeType::CHART_PLUS->value => [
            "basename" => "Chart Plus",
            "avLst" => [],
        ],
        MsoAutoShapeType::CHART_STAR->value => [
            "basename" => "Chart Star",
            "avLst" => [],
        ],
        MsoAutoShapeType::CHART_X->value => [
            "basename" => "Chart X",
            "avLst" => [],
        ],
        MsoAutoShapeType::CHEVRON->value => [
            "basename" => "Chevron",
            "avLst" => [
                ["adj", 50000],
            ],
        ],
        MsoAutoShapeType::CHORD->value => [
            "basename" => "Chord",
            "avLst" => [
                ["adj1", 2700000],
                ["adj2", 16200000],
            ],
        ],
        MsoAutoShapeType::CIRCULAR_ARROW->value => [
            "basename" => "Circular Arrow",
            "avLst" => [
                ["adj1", 12500],
                ["adj2", 1142319],
                ["adj3", 20457681],
                ["adj4", 10800000],
                ["adj5", 12500],
            ],
        ],
        MsoAutoShapeType::CLOUD->value => [
            "basename" => "Cloud",
            "avLst" => [],
        ],
        MsoAutoShapeType::CLOUD_CALLOUT->value => [
            "basename" => "Cloud Callout",
            "avLst" => [
                ["adj1", -20833],
                ["adj2", 62500],
            ],
        ],
        MsoAutoShapeType::CORNER->value => [
            "basename" => "Corner",
            "avLst" => [
                ["adj1", 50000],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::CORNER_TABS->value => [
            "basename" => "Corner Tabs",
            "avLst" => [],
        ],
        MsoAutoShapeType::CROSS->value => [
            "basename" => "Cross",
            "avLst" => [
                ["adj", 25000],
            ],
        ],
        MsoAutoShapeType::CUBE->value => [
            "basename" => "Cube",
            "avLst" => [
                ["adj", 25000],
            ],
        ],
        MsoAutoShapeType::CURVED_DOWN_ARROW->value => [
            "basename" => "Curved Down Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 50000],
                ["adj3", 25000],
            ],
        ],
        MsoAutoShapeType::CURVED_DOWN_RIBBON->value => [
            "basename" => "Curved Down Ribbon",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 50000],
                ["adj3", 12500],
            ],
        ],
        MsoAutoShapeType::CURVED_LEFT_ARROW->value => [
            "basename" => "Curved Left Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 50000],
                ["adj3", 25000],
            ],
        ],
        MsoAutoShapeType::CURVED_RIGHT_ARROW->value => [
            "basename" => "Curved Right Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 50000],
                ["adj3", 25000],
            ],
        ],
        MsoAutoShapeType::CURVED_UP_ARROW->value => [
            "basename" => "Curved Up Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 50000],
                ["adj3", 25000],
            ],
        ],
        MsoAutoShapeType::CURVED_UP_RIBBON->value => [
            "basename" => "Curved Up Ribbon",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 50000],
                ["adj3", 12500],
            ],
        ],
        MsoAutoShapeType::DECAGON->value => [
            "basename" => "Decagon",
            "avLst" => [
                ["vf", 105146],
            ],
        ],
        MsoAutoShapeType::DIAGONAL_STRIPE->value => [
            "basename" => "Diagonal Stripe",
            "avLst" => [
                ["adj", 50000],
            ],
        ],
        MsoAutoShapeType::DIAMOND->value => [
            "basename" => "Diamond",
            "avLst" => [

            ],
        ],
        MsoAutoShapeType::DODECAGON->value => [
            "basename" => "Dodecagon",
            "avLst" => [

            ],
        ],
        MsoAutoShapeType::DONUT->value => [
            "basename" => "Donut",
            "avLst" => [
                ["adj", 25000],
            ],
        ],
        MsoAutoShapeType::DOUBLE_BRACE->value => [
            "basename" => "Double Brace",
            "avLst" => [
                ["adj", 8333],
            ],
        ],
        MsoAutoShapeType::DOUBLE_BRACKET->value => [
            "basename" => "Double Bracket",
            "avLst" => [
                ["adj", 16667],
            ],
        ],
        MsoAutoShapeType::DOUBLE_WAVE->value => [
            "basename" => "Double Wave",
            "avLst" => [
                ["adj1", 6250],
                ["adj2", 0],
            ],
        ],
        MsoAutoShapeType::DOWN_ARROW->value => [
            "basename" => "Down Arrow",
            "avLst" => [
                ["adj1", 50000],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::DOWN_ARROW_CALLOUT->value => [
            "basename" => "Down Arrow Callout",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
                ["adj4", 64977],
            ],
        ],
        MsoAutoShapeType::DOWN_RIBBON->value => [
            "basename" => "Down Ribbon",
            "avLst" => [
                ["adj1", 16667],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::EXPLOSION1->value => [
            "basename" => "Explosion",
            "avLst" => [],
        ],
        MsoAutoShapeType::EXPLOSION2->value => [
            "basename" => "Explosion",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_ALTERNATE_PROCESS->value => [
            "basename" => "Alternate process",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_CARD->value => [
            "basename" => "Card",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_COLLATE->value => [
            "basename" => "Collate",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_CONNECTOR->value => [
            "basename" => "Connector",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_DATA->value => [
            "basename" => "Data",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_DECISION->value => [
            "basename" => "Decision",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_DELAY->value => [
            "basename" => "Delay",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_DIRECT_ACCESS_STORAGE->value => [
            "basename" => "Direct Access Storage",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_DISPLAY->value => [
            "basename" => "Display",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_DOCUMENT->value => [
            "basename" => "Document",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_EXTRACT->value => [
            "basename" => "Extract",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_INTERNAL_STORAGE->value => [
            "basename" => "Internal Storage",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_MAGNETIC_DISK->value => [
            "basename" => "Magnetic Disk",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_MANUAL_INPUT->value => [
            "basename" => "Manual Input",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_MANUAL_OPERATION->value => [
            "basename" => "Manual Operation",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_MERGE->value => [
            "basename" => "Merge",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_MULTIDOCUMENT->value => [
            "basename" => "Multidocument",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_OFFLINE_STORAGE->value => [
            "basename" => "Offline Storage",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_OFFPAGE_CONNECTOR->value => [
            "basename" => "Off-page Connector",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_OR->value => [
            "basename" => "Or",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_PREDEFINED_PROCESS->value => [
            "basename" => "Predefined Process",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_PREPARATION->value => [
            "basename" => "Preparation",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_PROCESS->value => [
            "basename" => "Process",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_PUNCHED_TAPE->value => [
            "basename" => "Punched Tape",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_SEQUENTIAL_ACCESS_STORAGE->value => [
            "basename" => "Sequential Access Storage",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_SORT->value => [
            "basename" => "Sort",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_STORED_DATA->value => [
            "basename" => "Stored Data",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_SUMMING_JUNCTION->value => [
            "basename" => "Summing Junction",
            "avLst" => [],
        ],
        MsoAutoShapeType::FLOWCHART_TERMINATOR->value => [
            "basename" => "Terminator",
            "avLst" => [],
        ],
        MsoAutoShapeType::FOLDED_CORNER->value => [
            "basename" => "Folded Corner",
            "avLst" => [],
        ],
        MsoAutoShapeType::FRAME->value => [
            "basename" => "Frame",
            "avLst" => [
                ["adj1", 12500],
            ],
        ],
        MsoAutoShapeType::FUNNEL->value => [
            "basename" => "Funnel",
            "avLst" => [],
        ],
        MsoAutoShapeType::GEAR_6->value => [
            "basename" => "Gear 6",
            "avLst" => [
                ["adj1", 15000],
                ["adj2", 3526],
            ],
        ],
        MsoAutoShapeType::GEAR_9->value => [
            "basename" => "Gear 9",
            "avLst" => [
                ["adj1", 10000],
                ["adj2", 1763],
            ],
        ],
        MsoAutoShapeType::HALF_FRAME->value => [
            "basename" => "Half Frame",
            "avLst" => [
                ["adj1", 33333],
                ["adj2", 33333],
            ],
        ],
        MsoAutoShapeType::HEART->value => [
            "basename" => "Heart",
            "avLst" => [],
        ],
        MsoAutoShapeType::HEPTAGON->value => [
            "basename" => "Heptagon",
            "avLst" => [
                ["hf", 102572],
                ["vf", 105210],
            ],
        ],
        MsoAutoShapeType::HEXAGON->value => [
            "basename" => "Hexagon",
            "avLst" => [
                ["adj", 25000],
                ["vf", 115470],
            ],
        ],
        MsoAutoShapeType::HORIZONTAL_SCROLL->value => [
            "basename" => "Horizontal Scroll",
            "avLst" => [
                ["adj", 12500],
            ],
        ],
        MsoAutoShapeType::ISOSCELES_TRIANGLE->value => [
            "basename" => "Isosceles Triangle",
            "avLst" => [
                ["adj", 50000],
            ],
        ],
        MsoAutoShapeType::LEFT_ARROW->value => [
            "basename" => "Left Arrow",
            "avLst" => [
                ["adj1", 50000],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::LEFT_ARROW_CALLOUT->value => [
            "basename" => "Left Arrow Callout",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
                ["adj4", 64977],
            ],
        ],
        MsoAutoShapeType::LEFT_BRACE->value => [
            "basename" => "Left Brace",
            "avLst" => [
                ["adj1", 8333],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::LEFT_BRACKET->value => [
            "basename" => "Left Bracket",
            "avLst" => [
                ["adj", 8333],
            ],
        ],
        MsoAutoShapeType::LEFT_CIRCULAR_ARROW->value => [
            "basename" => "Left Circular Arrow",
            "avLst" => [
                ["adj1", 12500],
                ["adj2", -1142319],
                ["adj3", 1142319],
                ["adj4", 10800000],
                ["adj5", 12500],
            ],
        ],
        MsoAutoShapeType::LEFT_RIGHT_ARROW->value => [
            "basename" => "Left-Right Arrow",
            "avLst" => [
                ["adj1", 50000],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::LEFT_RIGHT_ARROW_CALLOUT->value => [
            "basename" => "Left-Right Arrow Callout",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
                ["adj4", 48123],
            ],
        ],
        MsoAutoShapeType::LEFT_RIGHT_CIRCULAR_ARROW->value => [
            "basename" => "Left Right Circular Arrow",
            "avLst" => [
                ["adj1", 12500],
                ["adj2", 1142319],
                ["adj3", 20457681],
                ["adj4", 11942319],
                ["adj5", 12500],
            ],
        ],
        MsoAutoShapeType::LEFT_RIGHT_RIBBON->value => [
            "basename" => "Left Right Ribbon",
            "avLst" => [
                ["adj1", 50000],
                ["adj2", 50000],
                ["adj3", 16667],
            ],
        ],
        MsoAutoShapeType::LEFT_RIGHT_UP_ARROW->value => [
            "basename" => "Left-Right-Up Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
            ],
        ],
        MsoAutoShapeType::LEFT_UP_ARROW->value => [
            "basename" => "Left-Up Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
            ],
        ],
        MsoAutoShapeType::LIGHTNING_BOLT->value => [
            "basename" => "Lightning Bolt",
            "avLst" => [],
        ],
        MsoAutoShapeType::LINE_CALLOUT_1->value => [
            "basename" => "Line Callout 1",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 112500],
                ["adj4", -38333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_1_ACCENT_BAR->value => [
            "basename" => "Line Callout 1 (Accent Bar)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 112500],
                ["adj4", -38333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_1_BORDER_AND_ACCENT_BAR->value => [
            "basename" => "Line Callout 1 (Border and Accent Bar)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 112500],
                ["adj4", -38333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_1_NO_BORDER->value => [
            "basename" => "Line Callout 1 (No Border)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 112500],
                ["adj4", -38333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_2->value => [
            "basename" => "Line Callout 2",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 112500],
                ["adj6", -46667],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_2_ACCENT_BAR->value => [
            "basename" => "Line Callout 2 (Accent Bar)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 112500],
                ["adj6", -46667],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_2_BORDER_AND_ACCENT_BAR->value => [
            "basename" => "Line Callout 2 (Border and Accent Bar)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 112500],
                ["adj6", -46667],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_2_NO_BORDER->value => [
            "basename" => "Line Callout 2 (No Border)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 112500],
                ["adj6", -46667],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_3->value => [
            "basename" => "Line Callout 3",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 100000],
                ["adj6", -16667],
                ["adj7", 112963],
                ["adj8", -8333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_3_ACCENT_BAR->value => [
            "basename" => "Line Callout 3 (Accent Bar)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 100000],
                ["adj6", -16667],
                ["adj7", 112963],
                ["adj8", -8333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_3_BORDER_AND_ACCENT_BAR->value => [
            "basename" => "Line Callout 3 (Border and Accent Bar)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 100000],
                ["adj6", -16667],
                ["adj7", 112963],
                ["adj8", -8333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_3_NO_BORDER->value => [
            "basename" => "Line Callout 3 (No Border)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 100000],
                ["adj6", -16667],
                ["adj7", 112963],
                ["adj8", -8333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_4->value => [
            "basename" => "Line Callout 3",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 100000],
                ["adj6", -16667],
                ["adj7", 112963],
                ["adj8", -8333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_4_ACCENT_BAR->value => [
            "basename" => "Line Callout 3 (Accent Bar)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 100000],
                ["adj6", -16667],
                ["adj7", 112963],
                ["adj8", -8333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_4_BORDER_AND_ACCENT_BAR->value => [
            "basename" => "Line Callout 3 (Border and Accent Bar)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 100000],
                ["adj6", -16667],
                ["adj7", 112963],
                ["adj8", -8333],
            ],
        ],
        MsoAutoShapeType::LINE_CALLOUT_4_NO_BORDER->value => [
            "basename" => "Line Callout 3 (No Border)",
            "avLst" => [
                ["adj1", 18750],
                ["adj2", -8333],
                ["adj3", 18750],
                ["adj4", -16667],
                ["adj5", 100000],
                ["adj6", -16667],
                ["adj7", 112963],
                ["adj8", -8333],
            ],
        ],
        MsoAutoShapeType::LINE_INVERSE->value => [
            "basename" => "Straight Connector",
            "avLst" => [],
        ],
        MsoAutoShapeType::MATH_DIVIDE->value => [
            "basename" => "Division",
            "avLst" => [
                ["adj1", 23520],
                ["adj2", 5880],
                ["adj3", 11760],
            ],
        ],
        MsoAutoShapeType::MATH_EQUAL->value => [
            "basename" => "Equal",
            "avLst" => [
                ["adj1", 23520],
                ["adj2", 11760],
            ],
        ],
        MsoAutoShapeType::MATH_MINUS->value => [
            "basename" => "Minus",
            "avLst" => [
                ["adj1", 23520],
            ],
        ],
        MsoAutoShapeType::MATH_MULTIPLY->value => [
            "basename" => "Multiply",
            "avLst" => [
                ["adj1", 23520],
            ],
        ],
        MsoAutoShapeType::MATH_NOT_EQUAL->value => [
            "basename" => "Not Equal",
            "avLst" => [
                ["adj1", 23520],
                ["adj2", 6600000],
                ["adj3", 11760],
            ],
        ],
        MsoAutoShapeType::MATH_PLUS->value => [
            "basename" => "Plus",
            "avLst" => [
                ["adj1", 23520],
            ],
        ],
        MsoAutoShapeType::MOON->value => [
            "basename" => "Moon",
            "avLst" => [
                ["adj", 50000],
            ],
        ],
        MsoAutoShapeType::NON_ISOSCELES_TRAPEZOID->value => [
            "basename" => "Non-isosceles Trapezoid",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
            ],
        ],
        MsoAutoShapeType::NOTCHED_RIGHT_ARROW->value => [
            "basename" => "Notched Right Arrow",
            "avLst" => [
                ["adj1", 50000],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::NO_SYMBOL->value => [
            "basename" => "\"No\" Symbol",
            "avLst" => [
                ["adj", 18750],
            ],
        ],
        MsoAutoShapeType::OCTAGON->value => [
            "basename" => "Octagon",
            "avLst" => [
                ["adj", 29289],
            ],
        ],
        MsoAutoShapeType::OVAL->value => [
            "basename" => "Oval",
            "avLst" => [],
        ],
        MsoAutoShapeType::OVAL_CALLOUT->value => [
            "basename" => "Oval Callout",
            "avLst" => [
                ["adj1", -20833],
                ["adj2", 62500],
            ],
        ],
        MsoAutoShapeType::PARALLELOGRAM->value => [
            "basename" => "Parallelogram",
            "avLst" => [
                ["adj", 25000],
            ],
        ],
        MsoAutoShapeType::PENTAGON->value => [
            "basename" => "Pentagon",
            "avLst" => [
                ["adj", 50000],
            ],
        ],
        MsoAutoShapeType::PIE->value => [
            "basename" => "Pie",
            "avLst" => [
                ["adj1", 0],
                ["adj2", 16200000],
            ],
        ],
        MsoAutoShapeType::PIE_WEDGE->value => [
            "basename" => "Pie",
            "avLst" => [],
        ],
        MsoAutoShapeType::PLAQUE->value => [
            "basename" => "Plaque",
            "avLst" => [
                ["adj", 16667],
            ],
        ],
        MsoAutoShapeType::PLAQUE_TABS->value => [
            "basename" => "Plaque Tabs",
            "avLst" => [],
        ],
        MsoAutoShapeType::QUAD_ARROW->value => [
            "basename" => "Quad Arrow",
            "avLst" => [
                ["adj1", 22500],
                ["adj2", 22500],
                ["adj3", 22500],
            ],
        ],
        MsoAutoShapeType::QUAD_ARROW_CALLOUT->value => [
            "basename" => "Quad Arrow Callout",
            "avLst" => [
                ["adj1", 18515],
                ["adj2", 18515],
                ["adj3", 18515],
                ["adj4", 48123],
            ],
        ],
        MsoAutoShapeType::RECTANGLE->value => [
            "basename" => "Rectangle",
            "avLst" => [],
        ],
        MsoAutoShapeType::RECTANGULAR_CALLOUT->value => [
            "basename" => "Rectangular Callout",
            "avLst" => [
                ["adj1", -20833],
                ["adj2", 62500],
            ],
        ],
        MsoAutoShapeType::REGULAR_PENTAGON->value => [
            "basename" => "Regular Pentagon",
            "avLst" => [
                ["hf", 105146],
                ["vf", 110557],
            ],
        ],
        MsoAutoShapeType::RIGHT_ARROW->value => [
            "basename" => "Right Arrow",
            "avLst" => [
                ["adj1", 50000],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::RIGHT_ARROW_CALLOUT->value => [
            "basename" => "Right Arrow Callout",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
                ["adj4", 64977],
            ],
        ],
        MsoAutoShapeType::RIGHT_BRACE->value => [
            "basename" => "Right Brace",
            "avLst" => [
                ["adj1", 8333],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::RIGHT_BRACKET->value => [
            "basename" => "Right Bracket",
            "avLst" => [
                ["adj", 8333],
            ],
        ],
        MsoAutoShapeType::RIGHT_TRIANGLE->value => [
            "basename" => "Right Triangle",
            "avLst" => [],
        ],
        MsoAutoShapeType::ROUNDED_RECTANGLE->value => [
            "basename" => "Rounded Rectangle",
            "avLst" => [
                ["adj", 16667],
            ],
        ],
        MsoAutoShapeType::ROUNDED_RECTANGULAR_CALLOUT->value => [
            "basename" => "Rounded Rectangular Callout",
            "avLst" => [
                ["adj1", -20833],
                ["adj2", 62500],
                ["adj3", 16667],
            ],
        ],
        MsoAutoShapeType::ROUND_1_RECTANGLE->value => [
            "basename" => "Round Single Corner Rectangle",
            "avLst" => [
                ["adj", 16667],
            ],
        ],
        MsoAutoShapeType::ROUND_2_DIAG_RECTANGLE->value => [
            "basename" => "Round Diagonal Corner Rectangle",
            "avLst" => [
                ["adj1", 16667],
                ["adj2", 0],
            ],
        ],
        MsoAutoShapeType::ROUND_2_SAME_RECTANGLE->value => [
            "basename" => "Round Same Side Corner Rectangle",
            "avLst" => [
                ["adj1", 16667],
                ["adj2", 0],
            ],
        ],
        MsoAutoShapeType::SMILEY_FACE->value => [
            "basename" => "Smiley Face",
            "avLst" => [
                ["adj", 4653],
            ],
        ],
        MsoAutoShapeType::SNIP_1_RECTANGLE->value => [
            "basename" => "Snip Single Corner Rectangle",
            "avLst" => [
                ["adj", 16667],
            ],
        ],
        MsoAutoShapeType::SNIP_2_DIAG_RECTANGLE->value => [
            "basename" => "Snip Diagonal Corner Rectangle",
            "avLst" => [
                ["adj1", 0],
                ["adj2", 16667],
            ],
        ],
        MsoAutoShapeType::SNIP_2_SAME_RECTANGLE->value => [
            "basename" => "Snip Same Side Corner Rectangle",
            "avLst" => [
                ["adj1", 16667],
                ["adj2", 0],
            ],
        ],
        MsoAutoShapeType::SNIP_ROUND_RECTANGLE->value => [
            "basename" => "Snip and Round Single Corner Rectangle",
            "avLst" => [
                ["adj1", 16667],
                ["adj2", 16667],
            ],
        ],
        MsoAutoShapeType::SQUARE_TABS->value => [
            "basename" => "Square Tabs",
            "avLst" => [],
        ],
        MsoAutoShapeType::STAR_10_POINT->value => [
            "basename" => "10-Point Star",
            "avLst" => [
                ["adj", 42533],
                ["hf", 105146],
            ],
        ],
        MsoAutoShapeType::STAR_12_POINT->value => [
            "basename" => "12-Point Star",
            "avLst" => [
                ["adj", 37500],
            ],
        ],
        MsoAutoShapeType::STAR_16_POINT->value => [
            "basename" => "16-Point Star",
            "avLst" => [
                ["adj", 37500],
            ],
        ],
        MsoAutoShapeType::STAR_24_POINT->value => [
            "basename" => "24-Point Star",
            "avLst" => [
                ["adj", 37500],
            ],
        ],
        MsoAutoShapeType::STAR_32_POINT->value => [
            "basename" => "32-Point Star",
            "avLst" => [
                ["adj", 37500],
            ],
        ],
        MsoAutoShapeType::STAR_4_POINT->value => [
            "basename" => "4-Point Star",
            "avLst" => [
                ["adj", 12500],
            ],
        ],
        MsoAutoShapeType::STAR_5_POINT->value => [
            "basename" => "5-Point Star",
            "avLst" => [
                ["adj", 19098],
                ["hf", 105146],
                ["vf", 110557],
            ],
        ],
        MsoAutoShapeType::STAR_6_POINT->value => [
            "basename" => "6-Point Star",
            "avLst" => [
                ["adj", 28868],
                ["hf", 115470],
            ],
        ],
        MsoAutoShapeType::STAR_7_POINT->value => [
            "basename" => "7-Point Star",
            "avLst" => [
                ["adj", 34601],
                ["hf", 102572],
                ["vf", 105210],
            ],
        ],
        MsoAutoShapeType::STAR_8_POINT->value => [
            "basename" => "8-Point Star",
            "avLst" => [
                ["adj", 37500],
            ],
        ],
        MsoAutoShapeType::STRIPED_RIGHT_ARROW->value => [
            "basename" => "Striped Right Arrow",
            "avLst" => [
                ["adj1", 50000],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::SUN->value => [
            "basename" => "Sun",
            "avLst" => [
                ["adj", 25000],
            ],
        ],
        MsoAutoShapeType::SWOOSH_ARROW->value => [
            "basename" => "Swoosh Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 16667],
            ],
        ],
        MsoAutoShapeType::TEAR->value => [
            "basename" => "Teardrop",
            "avLst" => [
                ["adj", 100000],
            ],
        ],
        MsoAutoShapeType::TRAPEZOID->value => [
            "basename" => "Trapezoid",
            "avLst" => [
                ["adj", 25000],
            ],
        ],
        MsoAutoShapeType::UP_ARROW->value => [
            "basename" => "Up Arrow",
            "avLst" => [
                ["adj1", 50000],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::UP_ARROW_CALLOUT->value => [
            "basename" => "Up Arrow Callout",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
                ["adj4", 64977],
            ],
        ],
        MsoAutoShapeType::UP_DOWN_ARROW->value => [
            "basename" => "Up-Down Arrow",
            "avLst" => [
                ["adj1", 50000],
                ["adj1", 50000],
                ["adj2", 50000],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::UP_DOWN_ARROW_CALLOUT->value => [
            "basename" => "Up-Down Arrow Callout",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
                ["adj4", 48123],
            ],
        ],
        MsoAutoShapeType::UP_RIBBON->value => [
            "basename" => "Up Ribbon",
            "avLst" => [
                ["adj1", 16667],
                ["adj2", 50000],
            ],
        ],
        MsoAutoShapeType::U_TURN_ARROW->value => [
            "basename" => "U-Turn Arrow",
            "avLst" => [
                ["adj1", 25000],
                ["adj2", 25000],
                ["adj3", 25000],
                ["adj4", 43750],
                ["adj5", 75000],
            ],
        ],
        MsoAutoShapeType::VERTICAL_SCROLL->value => [
            "basename" => "Vertical Scroll",
            "avLst" => [
                ["adj", 12500],
            ],
        ],
        MsoAutoShapeType::WAVE->value => [
            "basename" => "Wave",
            "avLst" => [
                ["adj1", 12500],
                ["adj2", 0],
            ],
        ],

    ];
    /**
     * @var array<int,self>
     */
    private static array $instances = [];

    protected MsoAutoShapeType $_msoAutoShapeType;

    public function __construct(MsoAutoShapeType $msoAutoShapeType)
    {
        parent::__construct();
        if (isset($this['_loaded'])) {
            return;
        }

        if (!isset(self::$autoShapeTypes[$msoAutoShapeType->value])) {
            throw new Exception(sprintf("no autoshape type with id '%s' in pptx.spec.autoshape_types", $msoAutoShapeType->value));
        }

        $autoShapeType = self::$autoShapeTypes[$msoAutoShapeType->value];
        $this->_msoAutoShapeType = $msoAutoShapeType;
        $this->_baseName = $autoShapeType['baseName'];
        $this->_loaded = true;
    }

    public static function create(MsoAutoShapeType $autoShapeTypeId): AutoShapeType
    {
        if (!isset(self::$instances[$autoShapeTypeId->value])) {
            self::$instances[$autoShapeTypeId->value] = new AutoShapeType($autoShapeTypeId);
        }
        return self::$instances[$autoShapeTypeId->value];
    }

    public function getAutoShapeTypeId(): MsoAutoShapeType
    {
        return $this->_msoAutoShapeType;
    }

    public function getBaseName(): string
    {
        return htmlspecialchars($this->_baseName);
    }

    public static function defaultAdjustmentValues(MsoAutoShapeType $prst): array
    {
        return self::$autoShapeTypes[$prst->value]['avLst'];
    }

    public static function idFromPrst(string $prst): MsoAutoShapeType
    {
        return MsoAutoShapeType::fromXml($prst);
    }
}