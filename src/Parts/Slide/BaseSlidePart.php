<?php

namespace Imoing\Pptx\Parts\Slide;

use Imoing\Pptx\Opc\Constants\RT;
use Imoing\Pptx\Opc\XmlPart;
use Imoing\Pptx\OXml\Slide\CTSlide;
use Imoing\Pptx\Parts\Image\Image;
use Imoing\Pptx\Parts\Image\ImagePart;

/**
 * @property CTSlide $_element
 * @property-read string $name
 */
class BaseSlidePart extends XmlPart
{
    public function getImage(string $rId): Image
    {
        $part = $this->relatedPart($rId);
        assert($part instanceof  ImagePart);
        return $part->image;
    }

    public function getOrAddImagePart(string $imageFile): array
    {
        $imagePart = $this->_package->getOrAddImagePart($imageFile);
        $rId = $this->relateTo($imagePart, RT::IMAGE);

        return [$imagePart, $rId];
    }

    public function getName(): string
    {
        return $this->_element->cSld->name;
    }
}