<?php

namespace Imoing\Pptx\Common;

use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\ShapeTree\BaseShapes;

class Coordinate
{
    /**
     * 计算子节点偏移
     * @param $child BaseShape|BaseShapes
     * @param $parent BaseShape|BaseShapes
     * @return array 子节点偏移
     */
    public static function calChildOffset(BaseShape|BaseShapes $child, BaseShape|BaseShapes $parent): array
    {
        // 每一级存在 中心点、旋转角度
        // 根据上一级的中心点及旋转角度计算当前左上顶点、中心点位置
        // 旋转规则
        // 父级旋转会导致当前节点偏移跟着旋转
        // 节点偏移旋转后对应中心点同样需要旋转
        // 对应自定义图形相关坐标也需要旋转
        // 因此偏移节点及中心点为分别按照父级旋转逻辑旋转后再按照当前偏移及中心点旋转

        // 假定每一级有一个独立的坐标系 包含坐标点及坐标旋转角度
        // 子级相对父级坐标系及旋转角度再次处理
        // 每一级的相对坐标应当为父级的中心点 偏移应当是按照上级偏移旋转后的新坐标

        $radians = deg2rad($child->absRotation);
        $absOff = $parent->absOff;
        $offset = [$parent->left->emu, $parent->top->emu];
        $size = [$parent->width?->emu ?? 0, $parent->height?->emu ?? 0];
        $flipH = $parent->flipH;
        $flipV = $parent->flipV;

        // 按照父级旋转

        // 按照子级旋转

        // 反转坐标 flipH/flipV

        // 旋转
        $chSize = $parent->childSize;
        $scaleX = $chSize[0]->emu > 0 ? $size[0] / $chSize[0]->emu : 1;
        $scaleY = $chSize[1]->emu > 0 ? $size[1] / $chSize[1]->emu : 1;

        // 偏移
        $chOff = $parent->childOff;
        $childOffset = [($child->left?->emu ?: 0) - $chOff[0]->emu, ($child->top?->emu ?: 0) - $chOff[1]->emu];
        $childSize = [$child->width?->emu ?: 1, $child->height?->emu];
        $childCenter = [ $childSize[0] * $scaleX / 2, $childSize[1] * $scaleY / 2];// 中心点坐标

        // 假定scale为1
        //$childOffset = [$childOffset[0] - $childLeft, $childOffset[1] - $childTop];
        // TODO 旋转 (x-cx,y-cy) * (G_ext / chExt)

        //$rotateX = $childCenter[0] +  (0 - $childCenter[0]) * cos($radians) - (0 - $childCenter[1]) * sin($radians);
        //$rotateY = $childCenter[1] + (0 - $childCenter[0]) * sin($radians) + (0 - $childCenter[1]) * cos($radians);

        $rotateY = 0;
        $rotateX = 0;

        return  [$rotateX + $offset[0] + $childOffset[0], $rotateY + $offset[1] + $childOffset[1]];
    }
}