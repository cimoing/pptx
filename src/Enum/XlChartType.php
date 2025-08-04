<?php
namespace Imoing\Pptx\Enum;

enum XlChartType: int
{
    case THREE_D_AREA = -4098;
    case THREE_D_AREA_STACKED = 78;
    case THREE_D_AREA_STACKED_100 = 79;
    case THREE_D_BAR_CLUSTERED = 60;
    case THREE_D_BAR_STACKED = 61;
    case THREE_D_BAR_STACKED_100 = 62;
    case THREE_D_COLUMN = -4100;
    case THREE_D_COLUMN_CLUSTERED = 54;
    case THREE_D_COLUMN_STACKED = 55;
    case THREE_D_COLUMN_STACKED_100 = 56;
    case THREE_D_LINE = -4101;
    case THREE_D_PIE = -4102;
    case THREE_D_PIE_EXPLODED = 70;
    case AREA = 1;
    case AREA_STACKED = 76;
    case AREA_STACKED_100 = 77;
    case BAR_CLUSTERED = 57;
    case BAR_OF_PIE = 71;
    case BAR_STACKED = 58;
    case BAR_STACKED_100 = 59;
    case BUBBLE = 15;
    case BUBBLE_THREE_D_EFFECT = 87;
    case COLUMN_CLUSTERED = 51;
    case COLUMN_STACKED = 52;
    case COLUMN_STACKED_100 = 53;
    case CONE_BAR_CLUSTERED = 102;
    case CONE_BAR_STACKED = 103;
    case CONE_BAR_STACKED_100 = 104;
    case CONE_COL = 105;
    case CONE_COL_CLUSTERED = 99;
    case CONE_COL_STACKED = 100;
    case CONE_COL_STACKED_100 = 101;
    case CYLINDER_BAR_CLUSTERED = 95;
    case CYLINDER_BAR_STACKED = 96;
    case CYLINDER_BAR_STACKED_100 = 97;
    case CYLINDER_COL = 98;
    case CYLINDER_COL_CLUSTERED = 92;
    case CYLINDER_COL_STACKED = 93;
    case CYLINDER_COL_STACKED_100 = 94;
    case DOUGHNUT = -4120;
    case DOUGHNUT_EXPLODED = 80;
    case LINE = 4;
    case LINE_MARKERS = 65;
    case LINE_MARKERS_STACKED = 66;
    case LINE_MARKERS_STACKED_100 = 67;
    case LINE_STACKED = 63;
    case LINE_STACKED_100 = 64;
    case PIE = 5;
    case PIE_EXPLODED = 69;
    case PIE_OF_PIE = 68;
    case PYRAMID_BAR_CLUSTERED = 109;
    case PYRAMID_BAR_STACKED = 110;
    case PYRAMID_BAR_STACKED_100 = 111;
    case PYRAMID_COL = 112;
    case PYRAMID_COL_CLUSTERED = 106;
    case PYRAMID_COL_STACKED = 107;
    case PYRAMID_COL_STACKED_100 = 108;
    case RADAR = -4151;
    case RADAR_FILLED = 82;
    case RADAR_MARKERS = 81;
    case STOCK_HLC = 88;
    case STOCK_OHLC = 89;
    case STOCK_VHLC = 90;
    case STOCK_VOHLC = 91;
    case SURFACE = 83;
    case SURFACE_TOP_VIEW = 85;
    case SURFACE_TOP_VIEW_WIREFRAME = 86;
    case SURFACE_WIREFRAME = 84;
    case XY_SCATTER = -4169;
    case XY_SCATTER_LINES = 74;
    case XY_SCATTER_LINES_NO_MARKERS = 75;
    case XY_SCATTER_SMOOTH = 72;
    case XY_SCATTER_SMOOTH_NO_MARKERS = 73;

    public function description(): string
    {
        return match ($this) {
            self::THREE_D_AREA => '3D Area.',
            self::THREE_D_AREA_STACKED => '3D Stacked Area.',
            self::THREE_D_AREA_STACKED_100 => '100% Stacked Area.',
            self::THREE_D_BAR_CLUSTERED => '3D Clustered Bar.',
            self::THREE_D_BAR_STACKED => '3D Stacked Bar.',
            self::THREE_D_BAR_STACKED_100 => '3D 100% Stacked Bar.',
            self::THREE_D_COLUMN => '3D Column.',
            self::THREE_D_COLUMN_CLUSTERED => '3D Clustered Column.',
            self::THREE_D_COLUMN_STACKED => '3D Stacked Column.',
            self::THREE_D_COLUMN_STACKED_100 => '3D 100% Stacked Column.',
            self::THREE_D_LINE => '3D Line.',
            self::THREE_D_PIE => '3D Pie.',
            self::THREE_D_PIE_EXPLODED => 'Exploded 3D Pie.',
            self::AREA => 'Area',
            self::AREA_STACKED => 'Stacked Area.',
            self::AREA_STACKED_100 => '100% Stacked Area.',
            self::BAR_CLUSTERED => 'Clustered Bar.',
            self::BAR_OF_PIE => 'Bar of Pie.',
            self::BAR_STACKED => 'Stacked Bar.',
            self::BAR_STACKED_100 => '100% Stacked Bar.',
            self::BUBBLE => 'Bubble.',
            self::BUBBLE_THREE_D_EFFECT => 'Bubble with 3D effects.',
            self::COLUMN_CLUSTERED => 'Clustered Column.',
            self::COLUMN_STACKED => 'Stacked Column.',
            self::COLUMN_STACKED_100 => '100% Stacked Column.',
            self::CONE_BAR_CLUSTERED => 'Clustered Cone Bar.',
            self::CONE_BAR_STACKED => 'Stacked Cone Bar.',
            self::CONE_BAR_STACKED_100 => '100% Stacked Cone Bar.',
            self::CONE_COL => '3D Cone Column.',
            self::CONE_COL_CLUSTERED => 'Clustered Cone Column.',
            self::CONE_COL_STACKED => 'Stacked Cone Column.',
            self::CONE_COL_STACKED_100 => '100% Stacked Cone Column.',
            self::CYLINDER_BAR_CLUSTERED => 'Clustered Cylinder Bar.',
            self::CYLINDER_BAR_STACKED => 'Stacked Cylinder Bar.',
            self::CYLINDER_BAR_STACKED_100 => '100% Stacked Cylinder Bar.',
            self::CYLINDER_COL => '3D Cylinder Column.',
            self::CYLINDER_COL_CLUSTERED => 'Clustered Cone Column.',
            self::CYLINDER_COL_STACKED => 'Stacked Cone Column.',
            self::CYLINDER_COL_STACKED_100 => '100% Stacked Cylinder Column.',
            self::DOUGHNUT => 'Doughnut.',
            self::DOUGHNUT_EXPLODED => 'Exploded Doughnut.',
            self::LINE => 'Line.',
            self::LINE_MARKERS => 'Line with Markers.',
            self::LINE_MARKERS_STACKED => 'Stacked Line with Markers.',
            self::LINE_MARKERS_STACKED_100 => '100% Stacked Line with Markers.',
            self::LINE_STACKED => 'Stacked Line.',
            self::LINE_STACKED_100 => '100% Stacked Line.',
            self::PIE => 'Pie.',
            self::PIE_EXPLODED => 'Exploded Pie.',
            self::PIE_OF_PIE => 'Pie of Pie.',
            self::PYRAMID_BAR_CLUSTERED => 'Clustered Pyramid Bar.',
            self::PYRAMID_BAR_STACKED => 'Stacked Pyramid Bar.',
            self::PYRAMID_BAR_STACKED_100 => '100% Stacked Pyramid Bar.',
            self::PYRAMID_COL => '3D Pyramid Column.',
            self::PYRAMID_COL_CLUSTERED => 'Clustered Pyramid Column.',
            self::PYRAMID_COL_STACKED => 'Stacked Pyramid Column.',
            self::PYRAMID_COL_STACKED_100 => '100% Stacked Pyramid Column.',
            self::RADAR => 'Radar.',
            self::RADAR_FILLED => 'Filled Radar.',
            self::RADAR_MARKERS => 'Radar with Data Markers.',
            self::STOCK_HLC => 'High-Low-Close.',
            self::STOCK_OHLC => 'Open-High-Low-Close.',
            self::STOCK_VHLC => 'Volume-High-Low-Close.',
            self::STOCK_VOHLC => 'Volume-Open-High-Low-Close.',
            self::SURFACE => '3D Surface.',
            self::SURFACE_TOP_VIEW => 'Surface (Top View).',
            self::SURFACE_TOP_VIEW_WIREFRAME => 'Surface (Top View wireframe).',
            self::SURFACE_WIREFRAME => '3D Surface (wireframe).',
            self::XY_SCATTER => 'Scatter.',
            self::XY_SCATTER_LINES => 'Scatter with Lines.',
            self::XY_SCATTER_LINES_NO_MARKERS => 'Scatter with Lines and No Data Markers.',
            self::XY_SCATTER_SMOOTH => 'Scatter with Smoothed Lines.',
            self::XY_SCATTER_SMOOTH_NO_MARKERS => 'Scatter with Smoothed Lines and No Data Markers.',
        };
    }

    public function toString(): string
    {
        return "{$this->name} ({$this->value})";
    }
}
