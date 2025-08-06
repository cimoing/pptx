<?php

namespace Imoing\Pptx\Enum;


use Imoing\Pptx\Enum\Base\IBaseXmlEnum;
use Imoing\Pptx\Enum\Base\TraitXmlEnum;

/**
 * PowerPoint 预设颜色枚举 (a:prstClr values)
 * 命名规则：预设名全大写+下划线连接，值为自增数字
 */
enum PrstClr: int implements IBaseXmlEnum
{
    use TraitXmlEnum;

    case ALICE_BLUE = 1;
    case ANTIQUE_WHITE = 2;
    case AQUA = 3;
    case AQUAMARINE = 4;
    case AZURE = 5;
    case BEIGE = 6;
    case BISQUE = 7;
    case BLACK = 8;
    case BLANCHED_ALMOND = 9;
    case BLUE = 10;
    case BLUE_VIOLET = 11;
    case BROWN = 12;
    case BURLY_WOOD = 13;
    case CADET_BLUE = 14;
    case CHARTREUSE = 15;
    case CHOCOLATE = 16;
    case CORAL = 17;
    case CORNFLOWER_BLUE = 18;
    case CORNSILK = 19;
    case CRIMSON = 20;
    case CYAN = 21;
    case DARK_BLUE = 22;
    case DARK_CYAN = 23;
    case DARK_GOLDENROD = 24;
    case DARK_GRAY = 25;
    case DARK_GREEN = 26;
    case DARK_KHAKI = 27;
    case DARK_MAGENTA = 28;
    case DARK_OLIVE_GREEN = 29;
    case DARK_ORANGE = 30;
    case DARK_ORCHID = 31;
    case DARK_RED = 32;
    case DARK_SALMON = 33;
    case DARK_SEA_GREEN = 34;
    case DARK_SLATE_BLUE = 35;
    case DARK_SLATE_GRAY = 36;
    case DARK_TURQUOISE = 37;
    case DARK_VIOLET = 38;
    case DEEP_PINK = 39;
    case DEEP_SKY_BLUE = 40;
    case DIM_GRAY = 41;
    case DODGER_BLUE = 42;
    case FIREBRICK = 43;
    case FLORAL_WHITE = 44;
    case FOREST_GREEN = 45;
    case FUCHSIA = 46;
    case GAINSBORO = 47;
    case GHOST_WHITE = 48;
    case GOLD = 49;
    case GOLDENROD = 50;
    case GRAY = 51;
    case GREEN = 52;
    case GREEN_YELLOW = 53;
    case HONEYDEW = 54;
    case HOT_PINK = 55;
    case INDIAN_RED = 56;
    case INDIGO = 57;
    case IVORY = 58;
    case KHAKI = 59;
    case LAVENDER = 60;
    case LAVENDER_BLUSH = 61;
    case LAWN_GREEN = 62;
    case LEMON_CHIFFON = 63;
    case LIGHT_BLUE = 64;
    case LIGHT_CORAL = 65;
    case LIGHT_CYAN = 66;
    case LIGHT_GOLDENROD_YELLOW = 67;
    case LIGHT_GRAY = 68;
    case LIGHT_GREEN = 69;
    case LIGHT_PINK = 70;
    case LIGHT_SALMON = 71;
    case LIGHT_SEA_GREEN = 72;
    case LIGHT_SKY_BLUE = 73;
    case LIGHT_SLATE_GRAY = 74;
    case LIGHT_STEEL_BLUE = 75;
    case LIGHT_YELLOW = 76;
    case LIME = 77;
    case LIME_GREEN = 78;
    case LINEN = 79;
    case MAGENTA = 80;
    case MAROON = 81;
    case MEDIUM_AQUAMARINE = 82;
    case MEDIUM_BLUE = 83;
    case MEDIUM_ORCHID = 84;
    case MEDIUM_PURPLE = 85;
    case MEDIUM_SEA_GREEN = 86;
    case MEDIUM_SLATE_BLUE = 87;
    case MEDIUM_SPRING_GREEN = 88;
    case MEDIUM_TURQUOISE = 89;
    case MEDIUM_VIOLET_RED = 90;
    case MIDNIGHT_BLUE = 91;
    case MINT_CREAM = 92;
    case MISTY_ROSE = 93;
    case MOCCASIN = 94;
    case NAVAJO_WHITE = 95;
    case NAVY = 96;
    case OLD_LACE = 97;
    case OLIVE = 98;
    case OLIVE_DRAB = 99;
    case ORANGE = 100;
    case ORANGE_RED = 101;
    case ORCHID = 102;
    case PALE_GOLDENROD = 103;
    case PALE_GREEN = 104;
    case PALE_TURQUOISE = 105;
    case PALE_VIOLET_RED = 106;
    case PAPAYA_WHIP = 107;
    case PEACH_PUFF = 108;
    case PERU = 109;
    case PINK = 110;
    case PLUM = 111;
    case POWDER_BLUE = 112;
    case PURPLE = 113;
    case REBECCA_PURPLE = 114;
    case RED = 115;
    case ROSY_BROWN = 116;
    case ROYAL_BLUE = 117;
    case SADDLE_BROWN = 118;
    case SALMON = 119;
    case SANDY_BROWN = 120;
    case SEA_GREEN = 121;
    case SEA_SHELL = 122;
    case SIENNA = 123;
    case SILVER = 124;
    case SKY_BLUE = 125;
    case SLATE_BLUE = 126;
    case SLATE_GRAY = 127;
    case SNOW = 128;
    case SPRING_GREEN = 129;
    case STEEL_BLUE = 130;
    case TAN = 131;
    case TEAL = 132;
    case THISTLE = 133;
    case TOMATO = 134;
    case TURQUOISE = 135;
    case VIOLET = 136;
    case WHEAT = 137;
    case WHITE = 138;
    case WHITE_SMOKE = 139;
    case YELLOW = 140;
    case YELLOW_GREEN = 141;

    public static function getXmlValues(): array
    {
        return [
            self::ALICE_BLUE->value => ['aliceBlue', 'F0F8FF', '爱丽丝蓝'],
            self::ANTIQUE_WHITE->value => ['antiqueWhite', 'FAEBD7', '古董白'],
            self::AQUA->value => ['aqua', '00FFFF', '青色'],
            self::AQUAMARINE->value => ['aquamarine', '7FFFD4', '碧绿色'],
            self::AZURE->value => ['azure', 'F0FFFF', '天蓝色'],
            self::BEIGE->value => ['beige', 'F5F5DC', '米色'],
            self::BISQUE->value => ['bisque', 'FFE4C4', '橘黄色'],
            self::BLACK->value => ['black', '000000', '黑色'],
            self::BLANCHED_ALMOND->value => ['blanchedAlmond', 'FFEBCD', '杏仁白'],
            self::BLUE->value => ['blue', '0000FF', '蓝色'],
            self::BLUE_VIOLET->value => ['blueViolet', '8A2BE2', '蓝紫色'],
            self::BROWN->value => ['brown', 'A52A2A', '棕色'],
            self::BURLY_WOOD->value => ['burlyWood', 'DEB887', '硬木色'],
            self::CADET_BLUE->value => ['cadetBlue', '5F9EA0', '军蓝色'],
            self::CHARTREUSE->value => ['chartreuse', '7FFF00', '黄绿色'],
            self::CHOCOLATE->value => ['chocolate', 'D2691E', '巧克力色'],
            self::CORAL->value => ['coral', 'FF7F50', '珊瑚色'],
            self::CORNFLOWER_BLUE->value => ['cornflowerBlue', '6495ED', '矢车菊蓝'],
            self::CORNSILK->value => ['cornsilk', 'FFF8DC', '玉米丝色'],
            self::CRIMSON->value => ['crimson', 'DC143C', '深红色'],
            self::CYAN->value => ['cyan', '00FFFF', '青色'],
            self::DARK_BLUE->value => ['darkBlue', '00008B', '深蓝色'],
            self::DARK_CYAN->value => ['darkCyan', '008B8B', '深青色'],
            self::DARK_GOLDENROD->value => ['darkGoldenrod', 'B8860B', '深金色'],
            self::DARK_GRAY->value => ['darkGray', 'A9A9A9', '深灰色'],
            self::DARK_GREEN->value => ['darkGreen', '006400', '深绿色'],
            self::DARK_KHAKI->value => ['darkKhaki', 'BDB76B', '深卡其色'],
            self::DARK_MAGENTA->value => ['darkMagenta', '8B008B', '深洋红色'],
            self::DARK_OLIVE_GREEN->value => ['darkOliveGreen', '556B2F', '深橄榄绿'],
            self::DARK_ORANGE->value => ['darkOrange', 'FF8C00', '深橙色'],
            self::DARK_ORCHID->value => ['darkOrchid', '9932CC', '深兰花紫'],
            self::DARK_RED->value => ['darkRed', '8B0000', '深红色'],
            self::DARK_SALMON->value => ['darkSalmon', 'E9967A', '深鲑鱼色'],
            self::DARK_SEA_GREEN->value => ['darkSeaGreen', '8FBC8F', '深海绿色'],
            self::DARK_SLATE_BLUE->value => ['darkSlateBlue', '483D8B', '深岩蓝'],
            self::DARK_SLATE_GRAY->value => ['darkSlateGray', '2F4F4F', '深岩灰'],
            self::DARK_TURQUOISE->value => ['darkTurquoise', '00CED1', '深绿松石色'],
            self::DARK_VIOLET->value => ['darkViolet', '9400D3', '深紫罗兰色'],
            self::DEEP_PINK->value => ['deepPink', 'FF1493', '深粉色'],
            self::DEEP_SKY_BLUE->value => ['deepSkyBlue', '00BFFF', '深天蓝色'],
            self::DIM_GRAY->value => ['dimGray', '696969', '暗灰色'],
            self::DODGER_BLUE->value => ['dodgerBlue', '1E90FF', '道奇蓝'],
            self::FIREBRICK->value => ['firebrick', 'B22222', '耐火砖红'],
            self::FLORAL_WHITE->value => ['floralWhite', 'FFFAF0', '花卉白'],
            self::FOREST_GREEN->value => ['forestGreen', '228B22', '森林绿'],
            self::FUCHSIA->value => ['fuchsia', 'FF00FF', '紫红色'],
            self::GAINSBORO->value => ['gainsboro', 'DCDCDC', '庚斯博罗灰'],
            self::GHOST_WHITE->value => ['ghostWhite', 'F8F8FF', '幽灵白'],
            self::GOLD->value => ['gold', 'FFD700', '金色'],
            self::GOLDENROD->value => ['goldenrod', 'DAA520', '金菊色'],
            self::GRAY->value => ['gray', '808080', '灰色'],
            self::GREEN->value => ['green', '008000', '绿色'],
            self::GREEN_YELLOW->value => ['greenYellow', 'ADFF2F', '绿黄色'],
            self::HONEYDEW->value => ['honeydew', 'F0FFF0', '蜜瓜色'],
            self::HOT_PINK->value => ['hotPink', 'FF69B4', '亮粉色'],
            self::INDIAN_RED->value => ['indianRed', 'CD5C5C', '印度红'],
            self::INDIGO->value => ['indigo', '4B0082', '靛蓝色'],
            self::IVORY->value => ['ivory', 'FFFFF0', '象牙白'],
            self::KHAKI->value => ['khaki', 'F0E68C', '卡其色'],
            self::LAVENDER->value => ['lavender', 'E6E6FA', '薰衣草紫'],
            self::LAVENDER_BLUSH->value => ['lavenderBlush', 'FFF0F5', '薰衣草红'],
            self::LAWN_GREEN->value => ['lawnGreen', '7CFC00', '草坪绿'],
            self::LEMON_CHIFFON->value => ['lemonChiffon', 'FFFACD', '柠檬绸色'],
            self::LIGHT_BLUE->value => ['lightBlue', 'ADD8E6', '浅蓝色'],
            self::LIGHT_CORAL->value => ['lightCoral', 'F08080', '浅珊瑚色'],
            self::LIGHT_CYAN->value => ['lightCyan', 'E0FFFF', '浅青色'],
            self::LIGHT_GOLDENROD_YELLOW->value => ['lightGoldenrodYellow', 'FAFAD2', '浅金菊黄'],
            self::LIGHT_GRAY->value => ['lightGray', 'D3D3D3', '浅灰色'],
            self::LIGHT_GREEN->value => ['lightGreen', '90EE90', '浅绿色'],
            self::LIGHT_PINK->value => ['lightPink', 'FFB6C1', '浅粉色'],
            self::LIGHT_SALMON->value => ['lightSalmon', 'FFA07A', '浅鲑鱼色'],
            self::LIGHT_SEA_GREEN->value => ['lightSeaGreen', '20B2AA', '浅海绿色'],
            self::LIGHT_SKY_BLUE->value => ['lightSkyBlue', '87CEFA', '浅天蓝色'],
            self::LIGHT_SLATE_GRAY->value => ['lightSlateGray', '778899', '浅岩灰'],
            self::LIGHT_STEEL_BLUE->value => ['lightSteelBlue', 'B0C4DE', '浅钢蓝'],
            self::LIGHT_YELLOW->value => ['lightYellow', 'FFFFE0', '浅黄色'],
            self::LIME->value => ['lime', '00FF00', '酸橙色'],
            self::LIME_GREEN->value => ['limeGreen', '32CD32', '酸橙绿'],
            self::LINEN->value => ['linen', 'FAF0E6', '亚麻色'],
            self::MAGENTA->value => ['magenta', 'FF00FF', '洋红色'],
            self::MAROON->value => ['maroon', '800000', '栗色'],
            self::MEDIUM_AQUAMARINE->value => ['mediumAquamarine', '66CDAA', '中碧绿色'],
            self::MEDIUM_BLUE->value => ['mediumBlue', '0000CD', '中蓝色'],
            self::MEDIUM_ORCHID->value => ['mediumOrchid', 'BA55D3', '中兰花紫'],
            self::MEDIUM_PURPLE->value => ['mediumPurple', '9370DB', '中紫色'],
            self::MEDIUM_SEA_GREEN->value => ['mediumSeaGreen', '3CB371', '中海洋绿'],
            self::MEDIUM_SLATE_BLUE->value => ['mediumSlateBlue', '7B68EE', '中板岩蓝'],
            self::MEDIUM_SPRING_GREEN->value => ['mediumSpringGreen', '00FA9A', '中春绿色'],
            self::MEDIUM_TURQUOISE->value => ['mediumTurquoise', '48D1CC', '中绿松石色'],
            self::MEDIUM_VIOLET_RED->value => ['mediumVioletRed', 'C71585', '中紫罗兰红'],
            self::MIDNIGHT_BLUE->value => ['midnightBlue', '191970', '午夜蓝'],
            self::MINT_CREAM->value => ['mintCream', 'F5FFFA', '薄荷奶油色'],
            self::MISTY_ROSE->value => ['mistyRose', 'FFE4E1', '雾玫瑰色'],
            self::MOCCASIN->value => ['moccasin', 'FFE4B5', '鹿皮鞋色'],
            self::NAVAJO_WHITE->value => ['navajoWhite', 'FFDEAD', '纳瓦白'],
            self::NAVY->value => ['navy', '000080', '海军蓝'],
            self::OLD_LACE->value => ['oldLace', 'FDF5E6', '旧蕾丝色'],
            self::OLIVE->value => ['olive', '808000', '橄榄色'],
            self::OLIVE_DRAB->value => ['oliveDrab', '6B8E23', '橄榄褐'],
            self::ORANGE->value => ['orange', 'FFA500', '橙色'],
            self::ORANGE_RED->value => ['orangeRed', 'FF4500', '橙红色'],
            self::ORCHID->value => ['orchid', 'DA70D6', '兰花紫'],
            self::PALE_GOLDENROD->value => ['paleGoldenrod', 'EEE8AA', '灰金菊色'],
            self::PALE_GREEN->value => ['paleGreen', '98FB98', '灰绿色'],
            self::PALE_TURQUOISE->value => ['paleTurquoise', 'AFEEEE', '灰绿松石色'],
            self::PALE_VIOLET_RED->value => ['paleVioletRed', 'DB7093', '灰紫罗兰红'],
            self::PAPAYA_WHIP->value => ['papayaWhip', 'FFEFD5', '番木瓜色'],
            self::PEACH_PUFF->value => ['peachPuff', 'FFDAB9', '桃肉色'],
            self::PERU->value => ['peru', 'CD853F', '秘鲁色'],
            self::PINK->value => ['pink', 'FFC0CB', '粉色'],
            self::PLUM->value => ['plum', 'DDA0DD', '李紫色'],
            self::POWDER_BLUE->value => ['powderBlue', 'B0E0E6', '粉末蓝'],
            self::PURPLE->value => ['purple', '800080', '紫色'],
            self::REBECCA_PURPLE->value => ['rebeccaPurple', '663399', '丽贝卡紫'],
            self::RED->value => ['red', 'FF0000', '红色'],
            self::ROSY_BROWN->value => ['rosyBrown', 'BC8F8F', '玫瑰褐'],
            self::ROYAL_BLUE->value => ['royalBlue', '4169E1', '皇家蓝'],
            self::SADDLE_BROWN->value => ['saddleBrown', '8B4513', '鞍褐'],
            self::SALMON->value => ['salmon', 'FA8072', '鲑鱼色'],
            self::SANDY_BROWN->value => ['sandyBrown', 'F4A460', '沙褐'],
            self::SEA_GREEN->value => ['seaGreen', '2E8B57', '海洋绿'],
            self::SEA_SHELL->value => ['seaShell', 'FFF5EE', '贝壳色'],
            self::SIENNA->value => ['sienna', 'A0522D', '赭色'],
            self::SILVER->value => ['silver', 'C0C0C0', '银色'],
            self::SKY_BLUE->value => ['skyBlue', '87CEEB', '天蓝色'],
            self::SLATE_BLUE->value => ['slateBlue', '6A5ACD', '板岩蓝'],
            self::SLATE_GRAY->value => ['slateGray', '708090', '板岩灰'],
            self::SNOW->value => ['snow', 'FFFAFA', '雪色'],
            self::SPRING_GREEN->value => ['springGreen', '00FF7F', '春绿色'],
            self::STEEL_BLUE->value => ['steelBlue', '4682B4', '钢蓝'],
            self::TAN->value => ['tan', 'D2B48C', '棕褐色'],
            self::TEAL->value => ['teal', '008080', '凫蓝'],
            self::THISTLE->value => ['thistle', 'D8BFD8', '蓟色'],
            self::TOMATO->value => ['tomato', 'FF6347', '番茄色'],
            self::TURQUOISE->value => ['turquoise', '40E0D0', '绿松石色'],
            self::VIOLET->value => ['violet', 'EE82EE', '紫罗兰色'],
            self::WHEAT->value => ['wheat', 'F5DEB3', '小麦色'],
            self::WHITE->value => ['white', 'FFFFFF', '白色'],
            self::WHITE_SMOKE->value => ['whiteSmoke', 'F5F5F5', '白烟色'],
            self::YELLOW->value => ['yellow', 'FFFF00', '黄色'],
            self::YELLOW_GREEN->value => ['yellowGreen', '9ACD32', '黄绿色']
        ];
    }

    public function getDescription(): string
    {
        return self::getXmlValues()[$this->value][2] ?? '';
    }

    public function getColor(): string
    {
        return self::getXmlValues()[$this->value][1];
    }
}