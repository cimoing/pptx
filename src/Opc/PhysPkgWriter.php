<?php

namespace Imoing\Pptx\Opc;

abstract class PhysPkgWriter implements IPkgWriter
{
    public static function factory($pkgFile): static
    {
        return new ZipPkgWriter($pkgFile);
    }
}