<?php

namespace Imoing\Pptx\Parts\Image;

use Imoing\Pptx\IPackage;

interface IImagePart
{
    public function __construct(IPackage $package, IImage $image);

    public function desc(): string;

    public function ext(): string;

    public function image(): IImage;

    /**
     * @param int|null $scaledCx
     * @param int|null $scaledCy
     * @return array [scaledCx,scaledCy] after change
     */
    public function scale(?int $scaledCx, ?int $scaledCy): array;

    public function sha1(): string;
}