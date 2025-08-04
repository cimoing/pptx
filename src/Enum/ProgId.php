<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseEnum;
use Imoing\Pptx\Enum\Base\TraitEnum;

enum ProgId: string implements IBaseEnum
{
    use TraitEnum;

    case DOCX = 'DOCX';
    case PPTX = 'PPTX';
    case XLSX = 'XLSX';

    public function getDescription(): string
    {
        return match ($this) {
            self::DOCX => self::DOCX->name,
            self::PPTX => self::PPTX->name,
            self::XLSX => self::XLSX->name,
        };
    }

    public function getWidth(): int
    {
        return 965200;
    }

    public function getHeight(): int
    {
        return 609600;
    }

    public function getProgId(): string
    {
        return match ($this) {
            self::DOCX => "Word.Document.12",
            self::PPTX => "PowerPoint.Show.12",
            self::XLSX => "Excel.Sheet.12",
        };
    }

    public function getIconFileName(): string
    {
        return match ($this) {
            self::DOCX => "docx-icon.emf",
            self::PPTX => "pptx-icon.emf",
            self::XLSX => "xlsx-icon.emf",
        };
    }
}