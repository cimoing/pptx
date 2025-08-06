<?php

namespace Imoing\Pptx\Opc;

use Imoing\Pptx\Common\BaseObject;

/**
 * @property string $ext
 */
class PackURI extends BaseObject
{
    private string $uri;
    private static string $filenameRegex = '/^([a-zA-Z]+)([0-9]+)?/';

    public function __construct(string $packUriStr)
    {
        parent::__construct([]);
        assert($packUriStr[0] === '/');
        $this->uri = $packUriStr;
    }

    public static function fromRelRef(string $baseURI, string $relativeRef): self
    {
        $joinedUri = self::posixJoin($baseURI, $relativeRef);
        $absUri = self::posixAbs($joinedUri);
        return new self($absUri);
    }

    public function __toString(): string
    {
        return $this->uri;
    }

    public function getBaseURI(): string
    {
        return self::posixSplit($this->uri)[0];
    }

    public function getExt(): string
    {
        $rawExt = self::posixSplitext($this->uri)[1];
        return $rawExt === '' ? '' : ltrim($rawExt, '.');
    }

    public function getFilename(): string
    {
        return self::posixSplit($this->uri)[1];
    }

    public function getIdx(): ?int
    {
        $filename = $this->getFilename();
        if (!$filename) {
            return null;
        }

        $namePart = self::posixSplitext($filename)[0]; // remove extension
        if (preg_match(self::$filenameRegex, $namePart, $matches)) {
            if (!empty($matches[2])) {
                return (int)$matches[2];
            }
        }
        return null;
    }

    public function getMemberName(): string
    {
        return substr($this->uri, 1 - strlen($this->uri));
    }

    public function getRelativeRef(string $baseURI): string
    {
        return $baseURI === '/' ? substr($this->uri, 1) : self::posixRelPath($this->uri, $baseURI);
    }

    public function getRelsUri(): self
    {
        $relsFilename = "{$this->getFilename()}.rels";
        $relsUriStr = self::posixJoin($this->getBaseURI() === '/' ? '' : $this->getBaseURI(), '_rels', $relsFilename);

        return new self($relsUriStr);
    }

    // Simulated posixpath functions for compatibility
    private static function posixJoin(...$parts): string
    {
        $path = '';
        foreach ($parts as $part) {
            if (str_starts_with($part, '/')) {
                $path = $part;
            } else {
                $path = str_ends_with($path, '/') ? $path . $part : sprintf('%s/%s', $path, $part);
            }
        }

        return $path;
    }

    private static function posixAbs(string $path): string
    {
        $parts = explode('/', $path);
        $result = [];

        foreach ($parts as $part) {
            if ($part === '..') {
                array_pop($result);
            } elseif ($part !== '') {
                $result[] = $part;
            }
        }

        return '/' . implode('/', $result);
    }

    private static function posixSplit(string $path): array
    {
        $dirname = rtrim(substr($path, 0, strrpos($path, '/')), '/');
        $basename = substr($path, strrpos($path, '/') + 1);
        return [$dirname ?: '/', $basename];
    }

    private static function posixSplitext(string $path): array
    {
        $dotPos = strrpos($path, '.');
        if ($dotPos === false || $dotPos === 0 || $dotPos === strlen($path) - 1) {
            return [$path, ''];
        }
        return [substr($path, 0, $dotPos), substr($path, $dotPos)];
    }

    private static function posixRelPath(string $path, string $start): string
    {
        $pathParts = explode('/', trim($path, '/'));
        $startParts = explode('/', trim($start, '/'));

        $commonCount = 0;
        foreach ($pathParts as $i => $part) {
            if (isset($startParts[$i]) && $part === $startParts[$i]) {
                $commonCount++;
            } else {
                break;
            }
        }

        $upLevels = count($startParts) - $commonCount;
        $relPath = array_merge(array_fill(0, $upLevels, '..'), array_slice($pathParts, $commonCount));

        return implode('/', $relPath);
    }

    public static function packageURI(): static
    {
        return new static("/");
    }

    public static function contentTypesURI(): static
    {
        return new static("/[Content_Types].xml");
    }
}