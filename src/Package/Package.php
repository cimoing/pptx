<?php

namespace Imoing\Pptx\Package;

use Imoing\Pptx\Opc\Constants\RT;
use Imoing\Pptx\Opc\Package\OpcPackage;
use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\Parts\CoreProps\CorePropertiesPart;
use Imoing\Pptx\Parts\Image\ImagePart;
use Imoing\Pptx\Parts\Media\MediaPart;
use Imoing\Pptx\Parts\Presentation\PresentationPart;

/**
 * @property PresentationPart $presentationPart
 */
class Package extends OpcPackage
{

    public function getCoreProperties(): CorePropertiesPart
    {
        try {
            $obj = $this->partRelatedBy(RT::CORE_PROPERTIES);
            assert($obj instanceof CorePropertiesPart);
            return $obj;
        } catch (\Exception $e) {
            $obj = CorePropertiesPart::default($this);
            $this->relateTo($obj, RT::CORE_PROPERTIES);
            return $obj;
        }
    }

    public function getOrAddImagePart(string $imageFile): ImagePart
    {
        return $this->getImageParts()->getOrAddImagePart($imageFile);
    }

    public function getOrAddMediaPart(string $mediaFile): MediaPart
    {
        return $this->getMediaParts()->getOrAddMediaPart($mediaFile);
    }

    protected function getPresentationPart(): PresentationPart
    {
        return $this->getMainDocumentPart();
    }

    private ?ImageParts $_imageParts = null;
    protected function getImageParts(): ImageParts
    {
        if (is_null($this->_imageParts)) {
            $this->_imageParts = new ImageParts($this);
        }

        return $this->_imageParts;
    }

    private ?MediaParts $_mediaParts = null;
    protected function getMediaParts(): MediaParts
    {
        if (is_null($this->_mediaParts)) {
            $this->_mediaParts = new MediaParts($this);
        }
        return $this->_mediaParts;
    }

    public function getNextImagePartName(string $ext): PackURI
    {
        $firstAvailableImageIdx = function () {
            $imageIdxs = [];
            foreach($this->iterParts() as $part) {
                if (str_starts_with($part->partName, "/ppt/media/image") && !is_null($part->partName->idx)) {
                    $imageIdxs[] = $part->partName->idx;
                }
            }
            sort($imageIdxs, SORT_NUMERIC|SORT_ASC);
            foreach ($imageIdxs as $i => $imageIdx) {
                $idx = $i + 1;
                if ($idx < $imageIdxs) {
                    return $idx;
                }
            }

            return count($imageIdxs)+1;
        };

        $idx = $firstAvailableImageIdx();
        return new PackURI(sprintf("/ppt/media/image%d.%s", $idx, $ext));
    }

    public function getNextMediaPartName(string $ext): PackURI
    {
        $firstAvailableMediaIdx = function () {
            $mediaIdxs = [];
            foreach($this->iterParts() as $part) {
                if (str_starts_with($part->partName, "/ppt/media/media") && !is_null($part->partName->idx)) {
                    $mediaIdxs[] = $part->partName->idx;
                }
            }
            sort($mediaIdxs, SORT_NUMERIC|SORT_ASC);
            foreach ($mediaIdxs as $i => $imageIdx) {
                $idx = $i + 1;
                if ($idx < $mediaIdxs) {
                    return $idx;
                }
            }

            return count($mediaIdxs)+1;
        };

        $idx = $firstAvailableMediaIdx();
        return new PackURI(sprintf("/ppt/media/media%d.%s", $idx, $ext));
    }
}