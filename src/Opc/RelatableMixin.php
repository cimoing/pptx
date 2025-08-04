<?php

namespace Imoing\Pptx\Opc;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Opc\Package\Relationships;

abstract class RelatableMixin extends BaseObject
{
    abstract protected function getRelationships(): Relationships;


    public function partRelatedBy(string $relType): Part {
        return $this->getRelationships()->getPartWithRelationType($relType);
    }

    public function relateTo($target, string $relType, bool $isExternal = false): string {
        if (is_string($target)) {
            assert($isExternal);
            return $this->getRelationships()->getOrAddExtRel($relType, $target);
        }
        return $this->getRelationships()->getOrAdd($relType, $target);
    }

    public function relatedPart(string $rId): Part {
        return $this->getRelationships()[$rId]->getTargetPart();
    }

    public function targetRef(string $rId): string {
        return $this->getRelationships()[$rId]->getTargetRef();
    }
}