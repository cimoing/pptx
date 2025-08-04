<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\OXml\Shapes\Pictures\CTPicture;
use Imoing\Pptx\Parts\Image\ImagePart;

class PicturePlaceholder extends BaseSlidePlaceholder
{
    public function insertPicture($imageFile)
    {
        $pic = $this->newPlaceholderPic($imageFile);
        $this->replacePlaceholderWith($pic);

        return new PlaceholderPicture($pic, $this->_parent);
    }

    private function newPlaceholderPic($imageFile): CTPicture
    {
        list($rId, $desc, $imageSize) = $this->getOrAddImage($imageFile);
        list($shapeId, $name) = [$this->shapeId, $this->name];

        $pic = CTPicture::createPhPic($this->part->element->ownerDocument, $shapeId, $name, $desc, $rId);
        $pic->cropToFit($imageSize, [$this->width, $this->height]);
        return $pic;
    }

    private function getOrAddImage($imageFile)
    {
        list($imagePart, $rId) = $this->part->getOrAddImagePart($imageFile);
        assert($imagePart instanceof ImagePart);
        list($desc, $imageSize) = [$imagePart->desc, $imagePart->pxSize];

        return [$rId, $desc, $imageSize];
    }
}