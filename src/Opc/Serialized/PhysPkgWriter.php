<?php

namespace Imoing\Pptx\Opc\Serialized;

use Imoing\Pptx\Opc\PackURI;

abstract class PhysPkgWriter
{
    public static function factory(string $pkgFile): static
    {
        return new ZipPkgWriter($pkgFile);
    }

     abstract public function write(PackURI $packUri, string $blob): void;
}