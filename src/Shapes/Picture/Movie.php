<?php

namespace Imoing\Pptx\Shapes\Picture;

use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\Enum\PPMediaType;
use Imoing\Pptx\Parts\Image\Image;

/**
 * @property-read MediaFormat $mediaFormat
 * @property PPMediaType $mediaType
 * @property-read $posterFrame
 */
class Movie extends BasePicture
{
    private ?MediaFormat $_mediaFormat = null;
    public function getMediaFormat(): MediaFormat
    {
        if (null === $this->_mediaFormat) {
            $this->_mediaFormat = new MediaFormat($this->_picture, $this);
        }
        return $this->mediaFormat;
    }

    public function getMediaType(): PPMediaType
    {
        return PPMediaType::MOVIE;
    }

    /**
     * @return Image|null
     */
    public function getPosterFrame(): ?Image
    {
        list($slidePart, $rId) = [$this->part, $this->_picture->blipRId];
        if (is_null($rId)) {
            return null;
        }

        return $slidePart->getImage($rId);
    }

    public function getShapeType(): MsoShapeType
    {
        return MsoShapeType::MEDIA;
    }
}