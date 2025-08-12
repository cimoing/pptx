<?php

namespace Imoing\Pptx\Shapes\Picture;

use Imoing\Pptx\Enum\MsoAutoShapeType;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\Parts\Image\Image;

/**
 * @property ?MsoAutoShapeType $autoShapeType
 * @property-read ?Image $image
 */
class Picture extends BasePicture
{
    public function getAutoShapeType(): ?MsoAutoShapeType
    {
        $prstGeom = $this->_picture->spPr->prstGeom;
        if (is_null($prstGeom)) {
            return null;
        }

        return $prstGeom->prst;
    }

    public function setAutoShapeType(MsoAutoShapeType $autoShapeType): void
    {
        $spPr = $this->_picture->spPr;
        $psrtGeom = $spPr->prstGeom;
        if (is_null($psrtGeom)) {
            $spPr->_remove_custGeom();
            $prstGeom = $spPr->_add_prstGeom();
        }
        $prstGeom->prst = $autoShapeType;
    }

    public function getImage(): ?Image
    {
        list($slidePart, $rId) =  [$this->part, $this->_picture->blipRId];
        if (is_null($rId)) {
            throw new \Exception("no embedded image");
        }

        return $slidePart->getImage($rId);
    }

    public function getShapeType(): MsoShapeType
    {
        return MsoShapeType::PICTURE;
    }

    public function toArray(): array
    {
        $supportedGeom = ['roundRect', 'ellipse', 'triangle', 'rhombus', 'pentagon', 'hexagon', 'heptagon', 'octagon', 'parallelogram', 'trapezoid'];
        $geom = $this->getAutoShapeType()?->getXmlValue() ?: 'rect';

        $clip = $this->getClipArr();
        $clip['shape'] = in_array($geom, $supportedGeom) ? $geom : 'rect';

        return array_merge(parent::toArray(), [
            'type' => 'image',
            //'src' => $this->getImage()?->base64 ?: '',
            'fixedRatio' => true, // 固定图片宽高比例
            'outline' => $this->getOutlineArr(),
            'clip' => $clip,
            // filters 滤镜
            'flipH' => $this->getFlipH(),
            'flipV' => $this->getFlipV(),
            // shadow 阴影
            // radius 圆角半径
            // colorMask 颜色蒙版
            // imageType 图片类型 'pageFigure' | 'itemFigure' | 'background'
        ]);
    }
}