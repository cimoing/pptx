<?php

namespace Imoing\Pptx\Opc\Package;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Opc\Constants\RelationshipTargetMode;
use Imoing\Pptx\Opc\OXml\CTRelationship;
use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\Opc\Part;

/**
 * @property-read string $baseUri
 * @property-read string $rId
 * @property-read string $relType
 * @property-read string $targetMode
 * @property-read string|Part $target
 */
class Relationship extends BaseObject
{
    public function __construct(string $baseUri, string $rId, string $relType, string $targetMode, Part|string $target)
    {
        parent::__construct([
            'baseUri' => $baseUri,
            'relType' => $relType,
            'targetMode' => $targetMode,
            'target' => $target,
            'rId' => $rId,
        ]);
    }

    public static function fromXml(string $baseUri, CTRelationship $relationship, array $parts): static
    {
        $target = $relationship->targetMode == RelationshipTargetMode::EXTERNAL
            ? $relationship->targetRef
            : $parts[(string) PackURI::fromRelRef($baseUri, $relationship->targetRef)];

        return new static($baseUri, $relationship->rId, $relationship->relType, $relationship->targetMode, $target);
    }

    public function isExternal(): bool
    {
        return $this->targetMode == RelationshipTargetMode::EXTERNAL;
    }

    public function getTargetPart(): Part
    {
        assert(!$this->isExternal());
        $target = $this->target;
        assert($target instanceof Part);

        return $target;
    }

    public function getTargetPartName(): PackURI
    {
        assert(!$this->isExternal());
        $target = $this->target;
        assert($target instanceof Part);
        return $target->getPartName();
    }

    public function getTargetRef(): string
    {
        $target = $this->target;
        if ($this->isExternal()) {
            assert(is_string($target));

            return $target;
        }

        return $this->getTargetPartName()->getRelativeRef($this->baseUri);
    }
}