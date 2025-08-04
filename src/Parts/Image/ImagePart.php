<?php

namespace Imoing\Pptx\Parts\Image;

use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\Opc\Part;
use Imoing\Pptx\Package\Package;
use Imoing\Pptx\Util\Emu;

/**
 * @property string $desc
 * @property string $ext
 * @property Image $image
 * @property int $scaleCx
 * @property int $scaleCy
 * @property string $sha1
 * @property array $pxSize
 */
class ImagePart extends Part
{
    protected string $_blob;
    protected ?string $_filename;
    public function __construct(PackURI $partName, string $contentType, Package $package, string $blob, ?string $filename = null)
    {
        parent::__construct($partName, $contentType, $package, $blob);
        $this->_blob = $blob;
        $this->_filename = $filename;
    }

    public static function create(Package $package, Image $image): static
    {
        return new static($package->getNextImagePartName($image->ext), $image->contentType,$package,$image->blob,$image->fileName);
    }

    protected function getDesc(): string
    {
        return empty($this->_filename) ? "image.{$this->ext}" : $this->_filename;
    }

    protected function getImage(): Image
    {
        return new Image($this->_blob, $this->_filename);
    }

    public function scale(?int $scaledCx, ?int $scaledCy): array
    {
        list($imageCx, $imageCy) = $this->getNativeSize();
        if ($scaledCx !== null && $scaledCy !== null) {
            return [$scaledCx, $scaledCy];
        }

        if ($scaledCx !== null && $scaledCy === null) {
            $scalingFactor = $scaledCx / $imageCx->getEmu();
            $scaledCy = intval(round($imageCy->getEmu() * $scalingFactor));

            return [$scaledCx, $scaledCy];
        }

        if ($scaledCx === null && $scaledCy !== null) {
            $scalingFactor = $scaledCy / $imageCy->getEmu();
            $scaledCx = intval(round($imageCx->getEmu() * $scalingFactor));

            return [$scaledCx, $scaledCy];
        }

        return [$imageCx, $imageCy];
    }

    public function getSha1(): string
    {
        return $this->image->sha1;
    }
    private function getDpi(): array
    {
        return $this->image->dpi;
    }

    private function getNativeSize(): array
    {
        $emuPerInch = 914400;
        list($horzDpi, $vertDpi) = $this->getDpi();
        list($widthPx, $heightPx) = $this->getPxSize();

        $width = $emuPerInch * $widthPx / $horzDpi;
        $height = $emuPerInch * $heightPx / $vertDpi;

        return [new Emu($width), new Emu($height)];
    }

    protected function getPxSize(): array
    {
        return $this->image->size;
    }
}