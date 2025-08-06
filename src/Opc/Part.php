<?php

namespace Imoing\Pptx\Opc;

use Imoing\Pptx\IPackage;
use Imoing\Pptx\Opc\OXml\CTRelationships;
use Imoing\Pptx\Opc\Package\Relationships;
use Imoing\Pptx\Package\Package;

/**
 * @property PackURI $partName
 * @property Package $package
 * @property Relationships $rels
 */
class Part extends RelatableMixin {
    private PackURI $partName;
    private $content_type;
    private $_blob = null;
    private $_rels = null;
    private $_content_type = null;
    protected Package|null $_package = null;

    public function __construct(PackURI $partName, string $content_type, Package $package, ?string $blob = null) {
        parent::__construct([]);
        $this->partName = $partName;
        $this->content_type = $content_type;
        $this->_package = $package;
        $this->_blob = $blob;
    }

    /**
     * 工厂方法：用于子类重写以支持预处理
     */
    public static function load(PackURI $partName, string $contentType, Package $package, string $blob): self {
        return new static($partName, $contentType, $package, $blob);
    }

    /**
     * 获取 blob 内容（二进制/文本内容）
     */
    public function getBlob(): string {
        return $this->_blob ?: '';
    }

    /**
     * 设置 blob 内容
     */
    public function setBlob(string $blob): void {
        $this->_blob = $blob;
    }

    /**
     * 延迟加载 content_type
     */
    public function getContentType(): string {
        if ($this->_content_type === null) {
            $this->_content_type = $this->content_type;
        }
        return $this->_content_type;
    }

    /**
     * 从 XML 加载关系
     */
    public function loadRelsFromXml(CTRelationships $xmlRelationships, array $parts): void {
        $this->rels->loadFromXml($this->getPartName()->getBaseURI(), $xmlRelationships, $parts);
    }

    /**
     * 获取所属 package
     */
    public function getPackage(): Package {
        return $this->_package;
    }

    /**
     * 获取 partName（PackURI 对象）
     */
    public function getPartName(): PackURI {
        return $this->partName;
    }

    /**
     * 设置 partName（必须为 PackURI 类型）
     */
    public function setPartName(PackURI $partName): void {
        $this->partName = $partName;
    }

    protected function getRels(): Relationships
    {
        return $this->getRelationships();
    }

    /**
     * 从文件或资源中读取 blob 数据
     */
    protected function blobFromFile($file): string {
        if (is_string($file)) {
            if (!is_file($file)) {
                throw new \InvalidArgumentException("File does not exist: {$file}");
            }
            return file_get_contents($file);
        }

        if (is_resource($file)) {
            rewind($file);
            return stream_get_contents($file);
        }

        throw new \InvalidArgumentException("Invalid file type provided.");
    }

    private ?Relationships $_relations = null;
    public function getRelationships(): Relationships
    {
        if ($this->_relations === null) {
            $this->_relations = new Relationships($this->partName->getBaseURI());
        }
        return $this->_relations;
    }
}
