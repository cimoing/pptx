<?php

namespace Imoing\Pptx\Opc\Serialized;

use Imoing\Pptx\Opc\PackURI;

abstract class PhysPkgReader
{
    public static function factory(string $pkgFile):static
    {
        $realPath = realpath($pkgFile);
        if (is_dir($realPath)) {
            return new DirPkgReader($realPath);
        }

        return new ZipPkgReader($pkgFile);
    }

    public function has(PackURI $uri): bool
    {
        throw new \Exception('Not implemented');
    }

    public function getItem(PackURI $uri): string
    {
        throw new \Exception("Not implemented");
    }
}