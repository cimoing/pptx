<?php

namespace Imoing\Pptx\Opc\Package;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Common\TraitArrayAccess;
use Imoing\Pptx\Opc\Constants\RelationshipTargetMode;
use Imoing\Pptx\Opc\OXml\CTRelationships;
use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\Opc\Part;

/**
 * @property string $xml XML内容
 */
class Relationships extends BaseObject implements \ArrayAccess,\Countable {

    use TraitArrayAccess;
    private string $_baseUri;
    public function __construct(string $baseUri)
    {
        parent::__construct();
        $this->_baseUri = $baseUri;
    }
    public function getPartWithRelationType(string $relType): Part {
        $relations = $this->getRelationshipsByRelType($relType);
        if (count($relations) === 0) {
            throw new \Exception("no relationship of type {$relType}' in collection ");
        }

        if (count($relations) > 1) {
            throw new \Exception("multiple relationships of type {$relType}' in collection ");
        }

        return $relations[0]->getTargetPart();
    }

    public function getOrAdd(string $relType, Part $target): string {
        $existingRelationId = $this->getMatching($relType, $target);

        return $existingRelationId ?: $this->addRelationship($relType, $target);
    }

    public function getOrAddExtRel(string $relType, string $target): string {
        $existRid = $this->getMatching($relType, $target, true);
        return $existRid ?: $this->addRelationship($relType, $target, true);
    }

    public function loadFromXml(string $baseUri, CTRelationships $xmlRelationships, array $parts): void {
        $this->_relationships = [];
        foreach ($xmlRelationships->relationship_lst as $relationship) {
            if ($relationship->targetMode == RelationshipTargetMode::INTERNAL) {
                $partName = PackURI::fromRelRef($baseUri, $relationship->targetRef);
                if (!array_key_exists((string) $partName, $parts)) {
                    continue;
                }
            }
            $rel = Relationship::fromXml($baseUri, $relationship, $parts);
            $this->_relationships[$rel->rId] = $rel;
        }
    }

    private function getMatching(string $realType, Part|string $part, bool $isExternal = false): ?string
    {
        $items = $this->getRelationshipsByRelType($realType);
        foreach ($items as $item) {
            if ($item->isExternal() != $isExternal) {
                continue;
            }

            $refTarget = $item->isExternal() ? $item->targetMode : $item->getTargetPart();
            if ($refTarget == $part) {
                return $item->rId;
            }
        }

        return null;
    }

    private function addRelationship(string $relType, Part|string $part, bool $isExternal = false): string
    {
        $rId = $this->getNextRId();
        $this->_relationships[$rId] = new Relationship (
            $this->_baseUri,
            $rId,
            $relType,
            $isExternal ? RelationshipTargetMode::EXTERNAL : RelationshipTargetMode::INTERNAL,
            $part
        );

        return $rId;
    }

    private function getNextRId(): string
    {
        for ($n = count($this->_relationships) +1; $n > 0; $n--) {
            $rId = "rId{$n}";
            if (!array_key_exists($rId, $this->_relationships)) {
                return $rId;
            }
        }

        throw new \Exception('ProgrammingError: Impossible to have more distinct rIds than relationships');
    }

    /**
     * @var Relationship[]
     */
    private array $_relationships = [];

    private function getRelationships(): array
    {
        return $this->_relationships;
    }

    /**
     * @return Relationship[]
     */
    public function values(): array
    {
        return $this->_relationships;
    }

    public function offsetGet($offset): ?Relationship
    {
        return $this->_relationships[$offset] ?? null;
    }

    public function count(): int
    {
        return count($this->_relationships);
    }

    private ?array $_relationshipsByRelType = null;

    /**
     * @param string $relType
     * @return Relationship[]
     */
    public function getRelationshipsByRelType(string $relType): array
    {
        if (is_null($this->_relationshipsByRelType)) {
            $this->_relationshipsByRelType = [];
            foreach ($this->getRelationships() as $relationship) {
                $t = $relationship->relType;
                if (!array_key_exists($t, $this->_relationshipsByRelType)) {
                    $this->_relationshipsByRelType[$t] = [];
                }
                $this->_relationshipsByRelType[$t][] = $relationship;
            }
        }

        return $this->_relationshipsByRelType[$relType] ?? [];
    }

    public function getXml(): string
    {
        $relsElm = CTRelationships::create();

        $sortedRIdPairs = [];
        foreach ($this->getRelationships() as $rId => $relationship) {
            if (str_starts_with($rId, 'rId')) {
                $sortedRIdPairs[intval(substr($rId, 3, strlen($rId) - 3))] = $rId;
            } else {
                $sortedRIdPairs[0] = $rId;
            }

        }
        sort($sortedRIdPairs, SORT_NUMERIC|SORT_ASC);
        foreach ($sortedRIdPairs as $rId) {
            $relationship = $this->_relationships[$rId];
            $relsElm->addRelationship($rId,$relationship->relType,$relationship->getTargetRef(),$relationship->isExternal());
        }

        return $relsElm->xml();
    }

    public function pop(string $rId): void
    {
        unset($this->_relationships[$rId]);
    }
}
