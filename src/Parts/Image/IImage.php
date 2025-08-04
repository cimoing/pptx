<?php

namespace Imoing\Pptx\Parts\Image;

interface IImage
{
    public static function fromBlob(string $blob, ?string $fileName): IImage;

    public static function fromFile(string $imageFile): IImage;

    public function blob(): string;
    public function contentType(): string;

    /**
     * @return array [水平dpi,垂直dpi]，默认[72,72]
     */
    public function dpi(): array;

    public function ext(): string;

    public function fileName(): string;

    public function sha1(): string;

    /**
     * 获取大小（宽高）
     * @return array [宽,高]
     */
    public function size(): array;
}