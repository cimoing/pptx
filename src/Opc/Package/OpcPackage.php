<?php

namespace Imoing\Pptx\Opc\Package;

use Imoing\Pptx\IPackage;
use Imoing\Pptx\Opc\Constants\RT;
use Imoing\Pptx\Opc\PackageWriter;
use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\Opc\RelatableMixin;
use Imoing\Pptx\Parts\Presentation\PresentationPart;

/**
 * @property-read Relationships $relationships
 */
class OpcPackage extends RelatableMixin implements IPackage {

    private $pkgFile;
    private $_rels;

    public function __construct($pkgFile) {
        $this->pkgFile = $pkgFile;
    }

    public static function open($pkgFile): self {
        return (new static($pkgFile))->_load();
    }

    public function dropRel(string $rId): void {
        unset($this->_rels[$rId]);
    }

    public function iterParts(): \Generator {
        $visited = [];

        foreach ($this->iterRels() as $rel) {
            if ($rel->isExternal()) {
                continue;
            }

            $part = $rel->getTargetPart();

            if (in_array($part, $visited, true)) {
                continue;
            }

            yield $part;
            $visited[] = $part;
        }
    }

    public function iterRels(): \Generator {
        $visited = [];

        $walkRels = function (Relationships $rels) use (&$walkRels, &$visited) {
            foreach ($rels->values() as $rel) {
                yield $rel;

                if ($rel->isExternal()) {
                    continue;
                }

                $part = $rel->getTargetPart();

                if (in_array($part, $visited, true)) {
                    continue;
                }

                $visited[] = $part;

                yield from $walkRels($part->rels);
            }
        };

        yield from $walkRels($this->getRelationships());
    }

    public function getMainDocumentPart(): PresentationPart {
       $obj = $this->partRelatedBy(RT::OFFICE_DOCUMENT);
       assert($obj instanceof PresentationPart);
       return $obj;
    }

    public function nextPartName(string $tmpl): PackURI {
        $prefix = substr($tmpl, 0, strpos(str_replace('42', '%d', $tmpl), '%d'));

        $partNames = [];
        foreach ($this->iterParts() as $part) {
            if (str_starts_with($part->partname(), $prefix)) {
                $partNames[] = $part->partname();
            }
        }

        for ($n = count($partNames) + 1; $n > 0; $n--) {
            $candidate = sprintf($tmpl, $n);
            if (!in_array($candidate, $partNames)) {
                return new PackURI($candidate);
            }
        }

        throw new \RuntimeException("ProgrammingError: ran out of candidate_partnames");
    }

    public function save($pkgFile): void {
        PackageWriter::write($pkgFile, $this->relationships, iterator_to_array($this->iterParts()));
    }

    public function _load(): self {
        list($pkgXmlRelationships, $parts) = PackageLoader::load($this->pkgFile, $this);
        $this->relationships->loadFromXml(PackURI::packageURI(), $pkgXmlRelationships, $parts);
        return $this;
    }

    private ?Relationships $_relationships = null;
    public function getRelationships(): Relationships
    {
        if (!($this->_relationships)) {
            $this->_relationships = new Relationships(PackURI::packageURI()->getBaseURI());
        }

        return $this->_relationships;

    }

    public function __set($name, $value) {
        throw new \RuntimeException("Cannot set read-only property: {$name}");
    }

    private static bool $hasRegister = false;
}
