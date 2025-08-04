<?php

namespace Imoing\Pptx\Package;

use Imoing\Pptx\Opc\Constants\RT;
use Imoing\Pptx\Opc\Package\Relationship;

class MediaParts
{
    protected Package $_package;
    public function __construct(Package $package)
    {
        $this->_package = $package;
    }

    public function iter(): \Iterator
    {
        $mediaParts = [];;
        foreach($this->_package->iterRels() as $rel) {
            /**
             * @var Relationship $rel
             */
            if ($rel->isExternal()) {
                continue;
            }
            if (!in_array($rel->relType, [RT::VIDEO,RT::MEDIA])) {
                continue;
            }

            $mediaPart = $rel->getTargetPart();
            if (in_array($mediaPart, $mediaParts)) {
                continue;
            }
            $mediaParts[] = $mediaPart;
            yield $mediaPart;
        }
    }

    public function getOrAddMediaPart()
    {

    }
}