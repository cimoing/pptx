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
}