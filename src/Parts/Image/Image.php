<?php

namespace Imoing\Pptx\Parts\Image;

use Imoing\Pptx\Common\BaseObject;

/**
 * @property string $blob
 * @property string $base64
 * @property string $contentType
 * @property array $dpi
 * @property string $ext
 * @property ?string $fileName
 * @property string $sha1
 * @property int[] $size
 * @property int $width
 * @property int $height
 */
class Image extends BaseObject
{
    public function __construct(string $blob, ?string $filename)
    {
        parent::__construct([
            'blob' => $blob,
            'filename' => $filename,
        ]);
    }
    public static function fromBlob(string $blob, ?string $filename): Image
    {
        return new static($blob, $filename);
    }

    public static function fromFile(string $imageFile): Image
    {
        $fileName = basename($imageFile);
        return self::fromBlob(file_get_contents($imageFile), $fileName);
    }

    private ?array $_imageInfo = null;
    private function getImageInfo(): array
    {
        if (null === $this->_imageInfo) {
            $this->_imageInfo = getimagesizefromstring($this->blob);
            if (false === $this->_imageInfo) {
                throw new \Exception('Invalid image data');
            }
        }

        return $this->_imageInfo;
    }

    protected function getContentType(): string
    {
        //return mime_content_type($this->blob);
        $info = $this->getImageInfo();
        return $info['mime'];
    }

    protected function getDpi(): array
    {
        return [72,72];
    }

    protected function getExt(): string
    {
        return image_type_to_extension($this->getImageInfo()[2]);
    }

    private ?string $_sha1 = null;
    protected function getSha1(): string
    {
        if (null === $this->_sha1) {
            $this->_sha1 = sha1($this->blob);
        }
        return $this->_sha1;
    }

    protected function getWidth(): int
    {
        return $this->getImageInfo()[0];
    }

    protected function getHeight(): int
    {
        return $this->getImageInfo()[1];
    }

    protected function getSize(): array
    {
        return [$this->width, $this->height];
    }

    protected function setSize(array $values): void
    {
        list($this->width, $this->height) = $values;
    }

    protected function getBase64(): string
    {
        return sprintf('data:%s;base64,%s', $this->contentType, base64_encode($this->blob));
    }
}