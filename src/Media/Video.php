<?php

namespace Imoing\Pptx\Media;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Opc\Constants\ContentType;

/**
 * @property string $blob
 * @property ?string $filename
 * @property ?string $contentType
 * @property string $ext
 */
class Video extends BaseObject
{
    private ?string $_mimeType;
    public function __construct(string $blob, ?string $mimeType, ?string $filename)
    {
        parent::__construct([
            'blob' => $blob,
            'filename' => $filename,
        ]);
        $this->_mimeType = $mimeType;
    }

    public static function fromBlob(string $blob, ?string $mimeType = null, ?string $filename = null): static
    {
        return new static($blob, $mimeType, $filename);
    }

    public static function fromPathOrFileLike(string $moveFile, ?string $mimeType): static
    {
        return self::fromBlob(file_get_contents($moveFile), $mimeType, basename($moveFile));
    }

    protected function getContentType(): ?string
    {
        return $this->_mimeType;
    }

    protected function getExt(): string
    {
        if (!empty($this->filename)) {
            return explode(".", $this->filename)[1];
        }

        $maps = [
            ContentType::ASF => 'asf',
            ContentType::AVI => 'avi',
            ContentType::MOV => 'mov',
            ContentType::MP4 => 'mp4',
            ContentType::MPG => 'mpg',
            ContentType::MS_VIDEO => 'avi',
            ContentType::SWF => 'swf',
            ContentType::WMV => 'wmv',
            ContentType::X_MS_VIDEO => 'avi',
        ];

        return isset($maps[$this->contentType]) ? $maps[$this->contentType] : "vid";
    }

    private ?string $_sha1 = null;
    protected function getSha1(): string
    {
        if ($this->_sha1 === null) {
            $this->_sha1 = sha1($this->blob);
        }

        return $this->_sha1;
    }
}