<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;
use Imoing\Pptx\OXml\Shapes\Pictures\CTPicture;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\Connector;
use Imoing\Pptx\Shapes\GroupShape;
use Imoing\Pptx\Shapes\Picture\Movie;
use Imoing\Pptx\Shapes\Picture\Picture;
use Imoing\Pptx\Shapes\Placeholder\LayoutPlaceholder;
use Imoing\Pptx\Shapes\Placeholder\MasterPlaceholder;
use Imoing\Pptx\Shapes\Placeholder\NotesSlidePlaceholder;
use Imoing\Pptx\Shapes\Placeholder\PlaceholderGraphicFrame;
use Imoing\Pptx\Shapes\Placeholder\PlaceholderPicture;
use Imoing\Pptx\Shapes\Placeholder\SlidePlaceholder;
use Imoing\Pptx\Types\ProvidesPart;

class ShapeTree
{
    public static function baseShapeFactory(BaseShapeElement $shapeElement, ProvidesPart $parent): BaseShape
    {
        $tag = $shapeElement->tagName;
        if ($shapeElement instanceof CTPicture) {
            $files = $shapeElement->xpath("./p:nvPicPr/p:nvPr/a:videoFile");
            if ($files->length > 0) {
                return new Movie($shapeElement, $parent);
            }
            return new Picture($shapeElement, $parent);
        }

        $clsMap = [
            'p:cxnSp' => Connector::class,
            'p:grpSp' => GroupShape::class,
            'p:sp' => Shape::class,
            'p:pic' => Picture::class,
        ];
        $cls = $clsMap[$tag] ?? Shape::class;

        return new $cls($shapeElement, $parent);
    }

    public static function slideShapeFactory(BaseShapeElement $shapeElement, ProvidesPart $parent): BaseShape
    {
        if ($shapeElement->hasPhElm) {
            return self::slidePlaceholderFactory($shapeElement, $parent);
        }

        return self::baseShapeFactory($shapeElement, $parent);
    }

    private static function slidePlaceholderFactory(BaseShapeElement $shapeElement, ProvidesPart $parent): BaseShape
    {
        $tagName = $shapeElement->tagName;
        if ($tagName === "p:sp") {
            $cls = SlidePlaceholder::class;
        } elseif ($tagName === "p:graphicFrame") {
            $cls = PlaceholderGraphicFrame::class;
        } elseif ($tagName === "p:pic") {
            $cls = PlaceholderPicture::class;
        } else {
            return self::baseShapeFactory($shapeElement, $parent);
        }

        return new $cls($shapeElement, $parent);
    }

    public static function layoutShapeFactory(BaseShapeElement $shapeElement, ProvidesPart $parent): BaseShape
    {
        if ($shapeElement instanceof CTShape && $shapeElement->hasPhElm) {
            return new LayoutPlaceholder($shapeElement,$parent);
        }

        return self::baseShapeFactory($shapeElement, $parent);
    }

    public static function masterShapeFactory(BaseShapeElement $shapeElement, ProvidesPart $parent): BaseShape
    {
        if ($shapeElement instanceof CTShape && $shapeElement->hasPhElm) {
            return new MasterPlaceholder($shapeElement,$parent);
        }

        return self::baseShapeFactory($shapeElement, $parent);
    }

    public static function notesShapeFactory(BaseShapeElement $shapeElement, ProvidesPart $parent): BaseShape
    {
        if ($shapeElement instanceof CTShape && $shapeElement->hasPhElm) {
            return new NotesSlidePlaceholder($shapeElement,$parent);
        }

        return self::baseShapeFactory($shapeElement, $parent);
    }
}