<?php

namespace Imoing\Pptx\Parts\Media;

use Imoing\Pptx\Opc\Part;
use Imoing\Pptx\Package\Package;

/**
 * @property string $sha1
 */
class MediaPart extends Part
{
    public static function create(Package $package, $media): static
    {
        return new static($package->getNextMediaPartName($media->ext), $media->contentType, $package, $media->blob);
    }

    private ?string $_sha1 = null;
    protected function getSha1(): string
    {
        if (null === $this->_sha1) {
            $this->_sha1 = sha1($this->getBlob());
        }

        return $this->_sha1;
    }
}