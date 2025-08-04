<?php

namespace Imoing\Pptx\Opc\Serialized;

use Imoing\Pptx\Opc\PackURI;

class PackageReader
{
    private string $_pkgFile;
    public function __construct(string $pkgFile)
    {
        $this->_pkgFile = $pkgFile;
    }

    public function has(PackURI $uri): bool
    {
        return $this->blobReader()->has($uri);
    }

    public function getItem(PackURI $uri): string
    {
        return $this->blobReader()->getItem($uri);
    }

    public function getRelsXmlFor(PackURI $uri): ?string
    {
        $reader = $this->blobReader();
        $path = $uri->getRelsUri();

        if ($reader->has($path)) {
            return $reader->getItem($path);
        }

        return null;
    }

    private function blobReader(): PhysPkgReader
    {
        return PhysPkgReader::factory($this->_pkgFile);
    }
}