<?php

namespace Imoing\Pptx\Opc\Package;

use Imoing\Pptx\IPackage;
use Imoing\Pptx\Opc\OXml\CTRelationships;
use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\Opc\Part;
use Imoing\Pptx\Opc\Serialized\PackageReader;
use function Imoing\Pptx\Opc\parseXml;

class PackageLoader {
    private $pkgFile;
    private $package;

    // Lazy properties
    private ?ContentTypeMap $_contentTypes = null;
    private $_packageReader = null;
    private $_parts = null;
    private $_xmlRels = null;

    public function __construct($pkgFile, IPackage $package) {
        $this->pkgFile = $pkgFile;
        $this->package = $package;
    }

    /**
     * 入口方法：加载包并返回 (pkg_xml_rels, parts)
     */
    public static function load(
        $pkgFile,
        IPackage $package
    ): array {
        return (new static($pkgFile, $package))->_load();
    }

    protected function _load(): array {
        $parts = $this->getParts();
        $xmlRels = $this->getXmlRels();

        foreach ($parts as $partName => $part) {
            if (isset($xmlRels[$partName])) {
                $part->loadRelsFromXml($xmlRels[$partName], $parts);
            }
        }

        return [$xmlRels[(string) PackURI::packageURI()], $parts];
    }

    /**
     * 获取 content_types 对象
     */
    protected function getContentTypes(): ContentTypeMap
    {
        if (!$this->_contentTypes) {
            $this->_contentTypes = ContentTypeMap::fromXml(
                $this->getPackageReader()->getItem(PackURI::contentTypesURI())
            );
        }
        return $this->_contentTypes;
    }

    /**
     * 获取 package_reader 对象
     */
    protected function getPackageReader(): PackageReader {
        if (!$this->_packageReader) {
            $this->_packageReader = new PackageReader($this->pkgFile);
        }
        return $this->_packageReader;
    }

    /**
     * 获取所有 parts
     * @return Part[]
     * @throws \Exception
     */
    protected function getParts(): array {
        if (!$this->_parts) {
            $contentTypes = $this->getContentTypes();
            $package = $this->package;
            $packageReader = $this->getPackageReader();

            $parts = [];

            foreach ($this->getXmlRels() as $partName => $rels) {
                if ($partName === "/") continue;

                $packUri = new PackURI($partName);

                if ($packageReader->has($packUri)) {
                    $blob = $packageReader->getItem($packUri);
                    $contentType = $contentTypes->getItem($packUri);
                    $parts[$partName] = PartFactory::create($packUri, $contentType, $package, $blob);
                }
            }

            $this->_parts = $parts;
        }

        return $this->_parts;
    }

    /**
     * 获取 xml_rels 字典 { partname: CTRelationships }
     */
    protected function getXmlRels(): array {
        if (!$this->_xmlRels) {
            $xmlRelationships = [];
            $visited = [];

            $loadRelationships = function (PackURI $sourcePartName, CTRelationships $relationships) use (&$loadRelationships, &$xmlRelationships, &$visited) {
                $xmlRelationships[(string)$sourcePartName] = $relationships;
                $visited[] = (string) $sourcePartName;

                $baseUri = $sourcePartName->getBaseURI();

                foreach ($relationships->relationship_lst as $rel) {
                    if ($rel->isExternal()) continue;

                    $targetPartname = PackURI::fromRelRef($baseUri, $rel->targetRef);

                    if (in_array((string) $targetPartname, $visited, true)) {
                        continue;
                    }

                    $targetRels = $this->getXmlRelationshipsFor($targetPartname);

                    $loadRelationships($targetPartname, $targetRels);
                }
            };

            $packageRels = $this->getXmlRelationshipsFor(PackURI::packageURI());
            $loadRelationships(PackURI::packageURI(), $packageRels);

            $this->_xmlRels = $xmlRelationships;
        }

        return $this->_xmlRels;
    }

    /**
     * 解析指定 partname 的 rels XML
     */
    protected function getXmlRelationshipsFor(PackURI $partName): CTRelationships {
        $relXml = $this->getPackageReader()->getRelsXmlFor($partName);

        if ($relXml === null) {
            return CTRelationships::create();
        }

        $obj = \parseXml($relXml); // 假设 parseXml 是一个可用函数
        assert($obj instanceof CTRelationships);
        return $obj;
    }

    // --- 以下为魔术方法支持 lazyproperty 模拟 ---

    public function __get($name) {
        switch ($name) {
            case 'contentTypes':
                return $this->getContentTypes();
            case 'packageReader':
                return $this->getPackageReader();
            case 'parts':
                return $this->getParts();
            case 'xmlRels':
                return $this->getXmlRels();
            default:
                throw new \InvalidArgumentException("Property {$name} does not exist.");
        }
    }

    public function __set($name, $value) {
        throw new \RuntimeException("Cannot set read-only property: {$name}");
    }
}
