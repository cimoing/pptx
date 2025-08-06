<?php

namespace Imoing\Pptx\Opc\Package;

use Imoing\Pptx\IPackage;
use Imoing\Pptx\Opc\Constants\ContentType;
use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\Opc\Part;
use Imoing\Pptx\Parts\CoreProps\CorePropertiesPart;
use Imoing\Pptx\Parts\Image\ImagePart;
use Imoing\Pptx\Parts\Media\MediaPart;
use Imoing\Pptx\Parts\Presentation\PresentationPart;
use Imoing\Pptx\Parts\Slide\SlideLayoutPart;
use Imoing\Pptx\Parts\Slide\SlideMasterPart;
use Imoing\Pptx\Parts\Slide\SlidePart;
use Imoing\Pptx\Parts\Theme\OfficeStyleSheetPart;

class PartFactory
{
    public static function create(PackURI $partName, string $contentType, IPackage $package, string $blob): Part
    {
        $cls = self::getPartClass($contentType);
        return call_user_func([$cls, 'load'], $partName, $contentType, $package, $blob);
    }

    private static array $partTypeFor = [
        ContentType::PML_PRESENTATION_MAIN => PresentationPart::class,
        ContentType::PML_PRES_MACRO_MAIN => PresentationPart::class,
        ContentType::PML_TEMPLATE_MAIN => PresentationPart::class,
        ContentType::PML_SLIDESHOW_MAIN => PresentationPart::class,
        ContentType::OPC_CORE_PROPERTIES => CorePropertiesPart::class,
        //ContentType::PML_NOTES_MASTER => NotesMasterPart::class,
        //ContentType::PML_NOTES_SLIDE => NotesSlidePart::class,
        ContentType::PML_SLIDE => SlidePart::class,
        ContentType::PML_SLIDE_LAYOUT => SlideLayoutPart::class,
        ContentType::PML_SLIDE_MASTER => SlideMasterPart::class,
        //ContentType::DML_CHART => ChartPart::class,
        ContentType::BMP => ImagePart::class,
        ContentType::GIF => ImagePart::class,
        ContentType::JPEG => ImagePart::class,
        ContentType::MS_PHOTO => ImagePart::class,
        ContentType::PNG => ImagePart::class,
        ContentType::TIFF => ImagePart::class,
        ContentType::X_EMF => ImagePart::class,
        ContentType::X_WMF => ImagePart::class,
        ContentType::ASF => MediaPart::class,
        ContentType::AVI => MediaPart::class,
        ContentType::MOV => MediaPart::class,
        ContentType::MP4 => MediaPart::class,
        ContentType::MPG => MediaPart::class,
        ContentType::MS_VIDEO => MediaPart::class,
        ContentType::SWF => MediaPart::class,
        ContentType::VIDEO => MediaPart::class,
        ContentType::WMV => MediaPart::class,
        ContentType::X_MS_VIDEO => MediaPart::class,
        ContentType::OFC_THEME => OfficeStyleSheetPart::class,
    ];
    private static function getPartClass(string $contentType): string
    {
        return self::$partTypeFor[$contentType] ?? Part::class;
    }
}