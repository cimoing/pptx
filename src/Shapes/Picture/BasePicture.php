<?php

namespace Imoing\Pptx\Shapes\Picture;

use Imoing\Pptx\Dml\Line\LineFormat;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Shapes\Pictures\CTPicture;
use Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property float $cropBottom
 * @property float $cropLeft
 * @property float $cropTop
 * @property-read LineFormat $line
 * @property-read ?CTLineProperties $ln
 */
abstract class BasePicture extends BaseShape
{
    protected CTPicture $_picture;
    public function __construct(CTPicture $picture, ProvidesPart $parent)
    {
        parent::__construct($picture, $parent);
        $this->_picture = $picture;
    }

    public function getCropBottom(): float
    {
        return $this->_picture->getSrcRectB();
    }

    public function setCropBottom(float $cropBottom): void
    {
        $this->_picture->setSrcRectB($cropBottom);
    }

    public function getCropLeft(): float
    {
        return $this->_picture->getSrcRectL();
    }

    public function setCropLeft(float $cropLeft): void
    {
        $this->_picture->setSrcRectL($cropLeft);
    }

    public function getCropTop(): float
    {
        return $this->_picture->getSrcRectT();
    }

    public function setCropTop(float $cropTop): void
    {
        $this->_picture->setSrcRectT($cropTop);
    }

    private ?LineFormat $_line = null;
    public function getLine(): LineFormat
    {
        if (is_null($this->_line)) {
            $this->_line = new LineFormat($this);
        }
        return $this->_line;
    }

    public function getLn(): ?CTLineProperties
    {
        return $this->_picture->getLn();
    }

    public function get_or_add_ln(): CTLineProperties
    {
        return $this->_picture->get_or_add_ln();
    }

    public function getOutlineArr(): array
    {
        return $this->line->toArray();
    }

    public function getClipArr(): array
    {
        $prop = $this->_picture->blipFill->srcRect;
        if (empty($prop)) {
            return [
                'range' => [
                    [0,0],
                    [100,100],
                ],
            ];
        }

        return [
            'range' => [
                [
                    ($prop->l ?: 0) * 100,
                    ($prop->t ?: 0) * 100,
                ],
                [
                    100 - ($prop->r ?: 0) * 100,
                    100 - ($prop->b ?: 0) * 100,
                ],
            ],
        ];
    }
}