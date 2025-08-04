<?php

namespace Imoing\Pptx\Opc;

use ZipArchive;

class ZipPkgWriter extends PhysPkgWriter
{
    private ZipArchive $zip;
    private string $pkgFile;

    public function __construct($pkgFile)
    {
        $this->pkgFile = $pkgFile;
        $this->zip = new ZipArchive();
        $this->zip->open($pkgFile, ZipArchive::OVERWRITE | ZipArchive::CREATE);
    }

    public static function factory($pkgFile): static
    {
        return new self($pkgFile);
    }

    public function write(string $packUri, string $blob): void
    {
        $this->zip->addFromString(ltrim($packUri, '/'), $blob);
    }

    public function close(): void
    {
        $this->zip->close();
    }
}