<?php

namespace Imoing\Pptx\Package;

use Imoing\Pptx\Opc\Constants\RT;
use Imoing\Pptx\Opc\Package\Relationship;
use Imoing\Pptx\Parts\Image\Image;
use Imoing\Pptx\Parts\Image\ImagePart;

class ImageParts
{
    protected Package $_package;
    public function __construct(Package $package)
    {
        $this->_package = $package;
    }

    public function iter(): \Iterator
    {
        $imageParts = [];
        foreach ($this->_package->iterRels() as $rel) {
            /**
             * @var Relationship $rel
             */
            if ($rel->isExternal()) {
                continue;
            }
            if ($rel->relType != RT::IMAGE) {
                continue;
            }

            $imagePart = $rel->getTargetPart();
            if (in_array($imagePart, $imageParts)) {
                continue;
            }
            $imageParts[] = $imagePart;
            yield $imagePart;
        }
    }

    public function getOrAddImagePart(string $imageFile): ImagePart
    {
        $image = Image::fromFile($imageFile);
        $imagePart = $this->findBySha1($image->sha1);

        return $imagePart ?: ImagePart::create($this->_package, $image);

    }

    private function findBySha1(string $sha1): ?ImagePart
    {
        foreach($this->iter() as $part) {
            if (isset($part->sha1) && $part->sha1 == $sha1) {
                return $part;
            }
        }

        return null;
    }
}